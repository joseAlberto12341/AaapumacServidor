   document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.getElementById('tableBody');
            const addRowBtn = document.getElementById('addRow');
            const deleteRowBtn = document.getElementById('deleteRow');
            const saveDataBtn = document.getElementById('saveData');
            const cancelFormatBtn = document.getElementById('cancelFormat');
            const notification = document.getElementById('notification');
            const formPedimentos = document.getElementById('formPedimentos');
            const fechaHidden = document.getElementById('fecha');
            const horaHidden = document.getElementById('Hora');
            const fechaInput = document.getElementById('fechaInput');
            const totalPedimentosInput = document.getElementById('total_pedimentos');
            const datosPedimentosInput = document.getElementById('datos_pedimentos');

            let selectedRow = null;
            let syncEnabled = true;
            let rowCounter = 0;

            function createOperacionSelect(value = '', isFirstRow = false) {
                const select = document.createElement('select');
                select.className = 'operacion-select';

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Seleccionar...';
                defaultOption.disabled = true;
                defaultOption.selected = value === '';
                select.appendChild(defaultOption);

                const opciones = ['Importación', 'Exportación'];
                opciones.forEach(opcion => {
                    const option = document.createElement('option');
                    option.value = opcion;
                    option.textContent = opcion;
                    option.selected = (value === opcion);
                    select.appendChild(option);
                });

                if (isFirstRow) {
                    select.addEventListener('change', function () {
                        if (syncEnabled && this.value !== '') {
                            syncOperacionValues(this.value);
                        }
                    });
                }

                return select;
            }

            function createClaveSelect(value = '') {
                const select = document.createElement('select');
                select.className = 'clave-select';

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Seleccionar...';
                defaultOption.disabled = true;
                defaultOption.selected = value === '';
                select.appendChild(defaultOption);

                const opciones = ['A1', 'RT', 'A4'];
                opciones.forEach(opcion => {
                    const option = document.createElement('option');
                    option.value = opcion;
                    option.textContent = opcion;
                    option.selected = (value === opcion);
                    select.appendChild(option);
                });

                return select;
            }

            function createCRSelect(value = '', isFirstRow = false) {
                const select = document.createElement('select');
                select.className = 'cr-select';

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Seleccionar...';
                defaultOption.disabled = true;
                defaultOption.selected = value === '';
                select.appendChild(defaultOption);

                const opciones = ['39', '289', '291'];
                opciones.forEach(opcion => {
                    const option = document.createElement('option');
                    option.value = opcion;
                    option.textContent = opcion;
                    option.selected = (value === opcion);
                    select.appendChild(option);
                });

                if (isFirstRow) {
                    select.addEventListener('change', function () {
                        if (syncEnabled && this.value !== '') {
                            syncCRValues(this.value);
                        }
                    });
                }

                return select;
            }

            function syncOperacionValues(value) {
                const selects = tableBody.querySelectorAll('.operacion-select');
                selects.forEach((select, index) => {
                    if (index > 0) { // No sincronizar la primera fila (ya tiene el valor)
                        select.value = value;
                    }
                });

                showNotification(`Tipo de operación sincronizado: ${value}`);
            }

            function syncCRValues(value) {
                const selects = tableBody.querySelectorAll('.cr-select');
                selects.forEach((select, index) => {
                    if (index > 0) { // No sincronizar la primera fila (ya tiene el valor)
                        select.value = value;
                    }
                });

                showNotification(`CR sincronizado: ${value}`);
            }

            function showNotification(message) {
                notification.textContent = message;
                notification.classList.add('show');

                setTimeout(() => {
                    notification.classList.remove('show');
                }, 2000);
            }

            function recopilarDatosParaGuardar() {
                const rows = tableBody.querySelectorAll('tr');
                const pedimentos = [];
                
                rows.forEach((row) => {
                    if (!row.classList.contains('empty-row')) {
                        const cells = row.querySelectorAll('td');
                        if (cells.length >= 4) {
                            const pedimento = cells[0].textContent.trim();
                            const operacionSelect = cells[1].querySelector('select');
                            const claveSelect = cells[2].querySelector('select');
                            const crSelect = cells[3].querySelector('select');
                            
                            const operacion = operacionSelect ? operacionSelect.value : '';
                            const clave = claveSelect ? claveSelect.value : '';
                            const cr = crSelect ? crSelect.value : '';
                            
                            if (pedimento !== '' && operacion !== '') {
                                pedimentos.push({
                                    pedimento: pedimento,
                                    tipo_operacion: operacion,
                                    clave_pedimento: clave,
                                    cr: cr
                                });
                            }
                        }
                    }
                });
                
                return pedimentos;
            }

            function createRow(data = { pedimento: '', operacion: '', clave: '', cr: '' }, isFirstRow = false) {
                const row = document.createElement('tr');
                const currentRowIndex = rowCounter++;

                const pedimentoCell = document.createElement('td');
                pedimentoCell.contentEditable = true;
                pedimentoCell.className = 'editable';
                pedimentoCell.textContent = data.pedimento;
                row.appendChild(pedimentoCell);

                const operacionCell = document.createElement('td');
                const operacionSelect = createOperacionSelect(data.operacion, isFirstRow);
                operacionCell.appendChild(operacionSelect);
                row.appendChild(operacionCell);

                const claveCell = document.createElement('td');
                const claveSelect = createClaveSelect(data.clave);
                claveCell.appendChild(claveSelect);
                row.appendChild(claveCell);

                const crCell = document.createElement('td');
                const crSelect = createCRSelect(data.cr, isFirstRow);
                crCell.appendChild(crSelect);
                row.appendChild(crCell);

                const actionCell = document.createElement('td');
                actionCell.className = 'action-cell';

                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'btn btn-small';
                deleteBtn.innerHTML = '×';
                deleteBtn.type = 'button';
                deleteBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    row.remove();
                    if (selectedRow === row) {
                        selectedRow = null;
                    }
                    updateFirstRowSync();
                    
                    if (tableBody.children.length === 0) {
                        initializeTable();
                    }
                });

                actionCell.appendChild(deleteBtn);
                row.appendChild(actionCell);

                row.addEventListener('click', function () {
                    if (selectedRow) {
                        selectedRow.classList.remove('selected');
                    }
                    row.classList.add('selected');
                    selectedRow = row;
                });

                return row;
            }

            function updateFirstRowSync() {
                const firstRow = tableBody.querySelector('tr:not(.empty-row)');
                if (firstRow) {
                    // Actualizar sincronización de Tipo de operación
                    const firstOperacionSelect = firstRow.querySelector('.operacion-select');
                    if (firstOperacionSelect) {
                        const newOperacionSelect = firstOperacionSelect.cloneNode(true);
                        firstOperacionSelect.parentNode.replaceChild(newOperacionSelect, firstOperacionSelect);

                        newOperacionSelect.addEventListener('change', function () {
                            if (syncEnabled && this.value !== '') {
                                syncOperacionValues(this.value);
                            }
                        });
                    }

                    // Actualizar sincronización de CR
                    const firstCRSelect = firstRow.querySelector('.cr-select');
                    if (firstCRSelect) {
                        const newCRSelect = firstCRSelect.cloneNode(true);
                        firstCRSelect.parentNode.replaceChild(newCRSelect, firstCRSelect);

                        newCRSelect.addEventListener('change', function () {
                            if (syncEnabled && this.value !== '') {
                                syncCRValues(this.value);
                            }
                        });
                    }
                }
            }

            function initializeTable() {
                tableBody.innerHTML = '';
                rowCounter = 0;
                const emptyRow = document.createElement('tr');
                emptyRow.className = 'empty-row';
                emptyRow.innerHTML = '<td colspan="5">No hay datos. Haz clic en "Agregar Fila" para comenzar.</td>';
                tableBody.appendChild(emptyRow);
            }

            addRowBtn.addEventListener('click', function () {
                const emptyRow = tableBody.querySelector('.empty-row');
                if (emptyRow) {
                    emptyRow.remove();
                }

                const isFirstRow = tableBody.children.length === 0;
                const newRow = createRow({}, isFirstRow);
                tableBody.appendChild(newRow);
                newRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });

            deleteRowBtn.addEventListener('click', function () {
                if (selectedRow) {
                    selectedRow.remove();
                    selectedRow = null;

                    if (tableBody.children.length === 0) {
                        initializeTable();
                    } else {
                        updateFirstRowSync();
                    }
                } else {
                    alert('Por favor, selecciona una fila para eliminar.');
                }
            });

            saveDataBtn.addEventListener('click', function () {
                const pedimentos = recopilarDatosParaGuardar();

                if (pedimentos.length === 0) {
                    alert('Por favor, ingresa al menos un pedimento válido con tipo de operación.');
                    return;
                }

                const ahora = new Date();
                fechaHidden.value = fechaInput.value;
                horaHidden.value = ahora.toTimeString().split(' ')[0];
                totalPedimentosInput.value = pedimentos.length;
                datosPedimentosInput.value = JSON.stringify(pedimentos);

                console.log('Guardando pedimentos...', {
                    fecha: fechaHidden.value,
                    hora: horaHidden.value,
                    total_pedimentos: pedimentos.length,
                    datos_pedimentos: pedimentos
                });

                showNotification('Guardando datos en la base de datos...');

                formPedimentos.submit();
            });

            cancelFormatBtn.addEventListener('click', function () {
                if (confirm('¿Estás seguro de que deseas cancelar? Se perderán los cambios no guardados.')) {
                    initializeTable();
                }
            });

            initializeTable();
        });