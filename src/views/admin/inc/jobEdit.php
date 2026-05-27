<a href="/Aaapumac/admin/jobs">Regresar</a>
<br></br>
<div class="content-wrapper">
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"><?php echo $answer['data']['title']; ?></h4>
          <form method="post" id="trabajos" enctype="multipart/form-data" action="/Aaapumac/admin/editJob">
            <!--    CAMPO HIDDEN PARA EL ID -->
            <input type="hidden" name="id" value="<?php echo $answer['data']['job']->getId(); ?>">
            <input type="hidden" name="current_image" value="<?php echo $answer['data']['job']->getImage(); ?>">

            <p class="card-description">
              <?php echo $answer['data']['subtitle']; ?>
            </p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Título del Empleo</label>
                  <div class="col-sm-9">
                    <input name="title" id="title" type="text" class="form-control"
                      value="<?php echo $answer['data']['job']->getTitle(); ?>" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Vacantes</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" name="vacancy" id="vacancy"
                      value="<?php echo $answer['data']['job']->getVacancy(); ?>" placeholder="Número de Vacantes"
                      required />
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
                      placeholder="Descripción"><?php echo $answer['data']['job']->getDescription(); ?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label>Selecciona Imagen</label>
                  <!-- QUITAR REQUIRED Y MOSTRAR IMAGEN ACTUAL -->
                  <input type="file" name="image" id="image" class="form-control">
                  <?php if ($answer['data']['job']->getImage()): ?>
                    <small class="text-muted">
                      Imagen actual: <a href="<?php echo $answer['data']['job']->getImage(); ?>" target="_blank">Ver
                        imagen</a>
                    </small>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Fecha limite</label>
                  <div class="col-sm-9">
                    <input class="form-control" name="deadline" id="deadline" type="date"
                      value="<?php echo $answer['data']['job']->getDeadline(); ?>" placeholder="dd/mm/yyyy" required />
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
                      placeholder="Responsabilidades"><?php echo $answer['data']['job']->getResponsabilities(); ?></textarea>
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
                    <input type="text" name="education" id="education" class="form-control"
                      value="<?php echo $answer['data']['job']->getEducation(); ?>" placeholder="Educación" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Estatus</label>
                  <div class="col-sm-9">
                    <select name="id_status" id="id_status" class="form-control" required>
                      <option value="1" <?php echo $answer['data']['job']->getIdStatus() == 1 ? 'selected' : ''; ?>>Activo
                      </option>
                      <option value="0" <?php echo $answer['data']['job']->getIdStatus() == 0 ? 'selected' : ''; ?>>
                        Inactivo</option>
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
                    <input type="text" name="experience" id="experience" class="form-control"
                      value="<?php echo $answer['data']['job']->getExperience(); ?>" placeholder="Experiencia"
                      required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Conocimientos técnicos</label>
                  <div class="col-sm-9">
                    <input type="text" name="additional" id="additional" class="form-control"
                      value="<?php echo $answer['data']['job']->getAdditional(); ?>"
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
                      value="<?php echo $answer['data']['job']->getWorkexperience(); ?>"
                      placeholder="Años de Experiencia" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Salario</label>
                  <div class="col-sm-9">
                    <input type="number" name="salary" id="salary" class="form-control"
                      value="<?php echo $answer['data']['job']->getSalary(); ?>" placeholder="$" required />
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
                      value="<?php echo $answer['data']['job']->getContractType(); ?>" placeholder="Tipo de contrato"
                      required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Beneficios</label>
                  <div class="col-sm-9">
                    <input type="text" name="benefits" id="benefits" class="form-control"
                      value="<?php echo $answer['data']['job']->getBenefits(); ?>" placeholder="Beneficios" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Ubicación</label>
                  <div class="col-sm-9">
                    <input type="text" name="location" id="location" class="form-control"
                      value="<?php echo $answer['data']['job']->getLocation(); ?>" placeholder="Ubicación" required />
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary mb-2">Actualizar</button>
          </form>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

              // QUITAR VALIDACIÓN DE ARCHIVO OPCIONAL
              const archivo = document.getElementById('image').files[0];
              console.log('Archivo:', archivo);
              // No es requerido en edición

              if (problemas.length > 0) {
                console.log(' Problemas encontrados:', problemas);
                alert('Errores:\n' + problemas.join('\n'));
                return; // Detener aquí si hay errores
              }

              console.log(' Todos los campos están correctos, mostrando confirmación...');
              console.log('Datos a enviar:', datosCompletos);

              // SOLO SI TODOS LOS CAMPOS ESTÁN CORRECTOS, MOSTRAR CONFIRMACIÓN
              Swal.fire({
                title: "¿Estás seguro?",
                text: "¿Quieres actualizar este empleo?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, actualizar",
                cancelButtonText: "Cancelar"
              }).then((result) => {
                if (result.isConfirmed) {
                  // Enviar el formulario después de confirmar
                  this.submit();
                }
              });
            });
          </script>
        </div>
      </div>
    </div>
  </div>
</div>  