<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Contactos Minimalista</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            max-width: 2000px;
            margin: 0 auto;
        }
        
        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-top: 20px;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        h1 {
            color: #2c3e50;
            font-weight: 300;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #7f8c8d;
            font-size: 1.1rem;
        }
        
        .controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .search-box {
            position: relative;
            flex-grow: 1;
            max-width: 400px;
        }
        
        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #fafafa;
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            background-color: #fff;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
        }
        
        .contact-count {
            display: flex;
            align-items: center;
            color: #7f8c8d;
            font-size: 0.95rem;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        thead {
            background-color: #f8fafc;
            border-bottom: 2px solid #eee;
        }
        
        th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eee;
        }
        
        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }
        
        tbody tr:hover {
            background-color: #f9f9f9;
        }
        
        td {
            padding: 16px 15px;
            color: #34495e;
        }
        
        .contact-name {
            display: flex;
            align-items: center;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 12px;
            font-size: 1rem;
        }
        
        .name-info h3 {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 2px;
        }
        
        .name-info p {
            color: #7f8c8d;
            font-size: 0.85rem;
        }
        
        .contact-email i, .contact-phone i, .contact-company i {
            margin-right: 8px;
            color: #95a5a6;
            width: 20px;
        }
        
        .contact-email, .contact-phone, .contact-company {
            display: flex;
            align-items: center;
        }
        
        .contact-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .tag {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .tag-friend {
            background-color: #e8f6f3;
            color: #1abc9c;
        }
        
        .tag-work {
            background-color: #ebf5fb;
            color: #3498db;
        }
        
        .tag-family {
            background-color: #fef9e7;
            color: #f39c12;
        }
        
        footer {
            margin-top: 30px;
            text-align: center;
            color: #95a5a6;
            font-size: 0.9rem;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 20px 15px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .controls {
                flex-direction: column;
            }
            
            .search-box {
                max-width: 100%;
            }
            
            th, td {
                padding: 12px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Contactos</h1>
            <p class="subtitle">Lista de contactos de la Asociacion de Agentes aduanales del puerto de manzanillo colima</p>
        </header>
        
        <div class="controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Buscar contacto por nombre, email o empresa...">
            </div>
            <div class="contact-count">
                <i class="fas fa-users"></i>
                <span id="count">10 contactos</span>
            </div>
        </div>
        
        <div class="table-container">
            <table id="contactsTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Empresa</th>
                        <th>Categoría</th>
                    </tr>
                </thead>
                <tbody id="contactsBody">
                    <!-- Los contactos se cargarán aquí con JavaScript -->
                </tbody>
            </table>
        </div>
        
        <footer>
            <p>Tabla de contactos minimalista • 10 contactos disponibles</p>
        </footer>
    </div>

    <script>
        // Datos de los contactos
        const contacts = [
            {
                id: 1,
                firstName: "Ingeniero",
                lastName: "Ibis garcia",
                email: "ana.garcia@example.com",
                phone: "+34 612 345 678",
                company: "Aaapumac",
                category: "work"
            },
            {
                id: 2,
                firstName: "Ingeniero",
                lastName: "Oscar",
                email: "carlos.rodriguez@example.com",
                phone: "+34 623 456 789",
                company: "Aaapumac",
                category: "work2"
            },
            {
                id: 3,
                firstName: "María",
                lastName: "López",
                email: "maria.lopez@example.com",
                phone: "+34 634 567 890",
                company: "Aaapumac",
                category: "work3"
            },
            {
                id: 4,
                firstName: "Javier",
                lastName: "Martínez",
                email: "javier.martinez@example.com",
                phone: "+34 645 678 901",
                company: "Aaapumac",
                category: "work4"
            },
            {
                id: 5,
                firstName: "Laura",
                lastName: "Sánchez",
                email: "laura.sanchez@example.com",
                phone: "+34 656 789 012",
                company: "Aaapumac",
                category: "work5"
            },
            {
                id: 6,
                firstName: "David",
                lastName: "Fernández",
                email: "david.fernandez@example.com",
                phone: "+34 667 890 123",
                company: "Aaapumac",
                category: "work6"
            },
            {
                id: 7,
                firstName: "Elena",
                lastName: "Gómez",
                email: "elena.gomez@example.com",
                phone: "+34 678 901 234",
                company: "Aaapumac",
                category: "work7"
            },
            {
                id: 8,
                firstName: "Pedro",
                lastName: "Hernández",
                email: "pedro.hernandez@example.com",
                phone: "+34 689 012 345",
                company: "Aaapumac",
                category: "work8"
            },
            {
                id: 9,
                firstName: "Sofía",
                lastName: "Díaz",
                email: "sofia.diaz@example.com",
                phone: "+34 690 123 456",
                company: "Aaapumac",
                category: "work9"
            },
            {
                id: 10,
                firstName: "Miguel",
                lastName: "Ruiz",
                email: "miguel.ruiz@example.com",
                phone: "+34 601 234 567",
                company: "Aaapumac",
                category: "work10"
            }
        ];
        
        // Función para obtener el texto de la categoría
        function getCategoryText(category) {
            switch(category) {
                case 'work': return 'Director General';
                case 'work2': return 'Gerente operativo';
                case 'work3': return 'Coordinador de CallCenter';
                case 'work4': return 'Coordinador de TI';
                case 'work5': return 'Coordinador de Administración';
                case 'work6': return 'Coordinador de Juridico';
                case 'work7': return 'Gerente  Juridico';
                case 'work8': return 'Coordinador  de clasificación arancelaria';
                case 'work9': return 'Gerente de Calidad';
                case 'work10': return 'Departamento Antisoborno';
                default: return 'Otro';
            }
        }
        
        // Función para obtener la clase CSS de la categoría
        function getCategoryClass(category) {
            return `tag tag-${category}`;
        }
        
        // Función para renderizar la tabla de contactos
        function renderContacts(contactsToRender) {
            const contactsBody = document.getElementById('contactsBody');
            contactsBody.innerHTML = '';
            
            contactsToRender.forEach(contact => {
                const row = document.createElement('tr');
                
                // Crear el avatar con las iniciales
                const initials = contact.firstName.charAt(0) + contact.lastName.charAt(0);
                
                row.innerHTML = `
                    <td>
                        <div class="contact-name">
                            <div class="avatar">${initials}</div>
                            <div class="name-info">
                                <h3>${contact.firstName} ${contact.lastName}</h3>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="contact-email">
                            <i class="fas fa-envelope"></i>
                            ${contact.email}
                        </div>
                    </td>
                    <td>
                        <div class="contact-phone">
                            <i class="fas fa-phone"></i>
                            ${contact.phone}
                        </div>
                    </td>
                    <td>
                        <div class="contact-company">
                            <i class="fas fa-building"></i>
                            ${contact.company}
                        </div>
                    </td>
                    <td>
                        <div class="contact-tags">
                            <span class="${getCategoryClass(contact.category)}">${getCategoryText(contact.category)}</span>
                        </div>
                    </td>
                `;
                
                contactsBody.appendChild(row);
            });
            
            // Actualizar contador
            document.getElementById('count').textContent = `${contactsToRender.length} contactos`;
        }
        
        // Función para buscar contactos
        function searchContacts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            if (!searchTerm) {
                renderContacts(contacts);
                return;
            }
            
            const filteredContacts = contacts.filter(contact => {
                return (
                    contact.firstName.toLowerCase().includes(searchTerm) ||
                    contact.lastName.toLowerCase().includes(searchTerm) ||
                    contact.email.toLowerCase().includes(searchTerm) ||
                    contact.company.toLowerCase().includes(searchTerm) ||
                    getCategoryText(contact.category).toLowerCase().includes(searchTerm)
                );
            });
            
            renderContacts(filteredContacts);
        }
        
        // Inicializar la tabla cuando se carga la página
        document.addEventListener('DOMContentLoaded', () => {
            renderContacts(contacts);
            
            // Configurar el evento de búsqueda
            document.getElementById('searchInput').addEventListener('input', searchContacts);
        });
    </script>
</body>
</html> 