<a href="/Aaapumac/admin/jobs">Regresar</a>
<br></br>
<div class="content-wrapper">
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"><?php echo $answer['data']['title']; ?></h4>
          <form method="post" id="trabajos" enctype="multipart/form-data" action="/Aaapumac/admin/NewJob">
            <p class="card-description">
              <?php echo $answer['data']['subtitle']; ?>
            </p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Título del Empleo</label>
                  <div class="col-sm-9">
                    <input name="title" id="title" type="text" class="form-control"
                      value="<?php echo isset($answer['data']['job']) ? $answer['data']['job']->getTitle() : ''; ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Vacantes</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="vacancy" id="vacancy"
                      placeholder="Número de Vacantes" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Descripción</label>
                </div>
                <div class="form-group row">
                  <div class="col-lg-12">
                    <textarea name="description" id="description" class="form-control"
                      placeholder="Descripción"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label>Selecciona Imagen</label>
                  <input type="file" name="image" id="image" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Fecha limite</label>
                  <div class="col-sm-9">
                    <input class="form-control" name="deadline" id="deadline" type="date" placeholder="dd/mm/yyyy"
                      required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group row">
                  <label class="col-lg-3 col-form-label">Responsabilidades</label>
                </div>
                <div class="form-group row">
                  <div class="col-lg-12">
                    <textarea name="responsibilities" id="responsibilities" class="form-control"
                      placeholder="Responsabilidades"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <p class="card-description">
              Datos Adicionales
            </p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Educación</label>
                  <div class="col-sm-9">
                    <input type="text" name="education" id="education" class="form-control" placeholder="Educación"
                      required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Estatus</label>
                  <div class="col-sm-9">
                    <select name="id_status" id="id_status" class="form-control" required>
                      <option value="1" selected>Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Experiencia</label>
                  <div class="col-sm-9">
                    <input type="text" name="experience" id="experience" class="form-control" placeholder="Experiencia"
                      required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Conocimientos técnicos</label>
                  <div class="col-sm-9">
                    <input type="text" name="additional" id="additional" class="form-control"
                      placeholder="Conocimientos técnicos" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Años de Experiencia</label>
                  <div class="col-sm-9">
                    <input type="text" name="workexperience" id="workexperience" class="form-control"
                      placeholder="Años de Experiencia" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Salario</label>
                  <div class="col-sm-9">
                    <input type="number" name="salary" id="salary" class="form-control" placeholder="$" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tipo de contrato</label>
                  <div class="col-sm-9">
                    <input type="text" name="contract_type" id="contract_type" class="form-control"
                      placeholder="Tipo de contrato" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Beneficios</label>
                  <div class="col-sm-9">
                    <input type="text" name="benefits" id="benefits" class="form-control" placeholder="Beneficios"
                      required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Ubicación</label>
                  <div class="col-sm-9">
                    <input type="text" name="location" id="location" class="form-control" placeholder="Ubicación"
                      required />
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary mb-2">guardar</button>
          </form>
          <script>
            document.getElementById('trabajos').addEventListener('submit', function (e) {
              e.preventDefault();

              console.log('=== VERIFICACIÓN COMPLETA DEL FORMULARIO ===');

              const campos = ['title', 'vacancy', 'description', 'deadline', 'responsibilities',
                'education', 'experience', 'additional', 'workexperience', 'salary',
                'contract_type', 'benefits', 'location', 'id_status'];

              let datosCompletos = {};
              let problemas = [];

              campos.forEach(campo => {
                const elemento = document.getElementById(campo);
                if (elemento) {
                  const valor = elemento.value;
                  datosCompletos[campo] = valor;
                  console.log(` ${campo}: "${valor}"`);

                  if (!valor.trim() && elemento.hasAttribute('required')) {
                    problemas.push(`${campo} (requerido pero vacío)`);
                  }
                } else {
                  console.log(` ${campo}: ELEMENTO NO ENCONTRADO`);
                  problemas.push(`${campo} (elemento no existe)`);
                }
              });

              // Verificar archivo
              const archivo = document.getElementById('image').files[0];
              console.log('Archivo:', archivo);

              if (!archivo) {
                problemas.push('image (no se seleccionó archivo)');
              }

              if (problemas.length > 0) {
                console.log(' Problemas encontrados:', problemas);
                alert('Errores:\n' + problemas.join('\n'));
              } else {
                console.log(' Todos los campos están correctos, enviando formulario...');
                console.log('Datos a enviar:', datosCompletos);
                this.submit();
              }
            });
          </script>
        </div>
      </div>
    </div>
  </div>
</div>