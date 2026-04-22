<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $answer['data']['title']; ?></h4>
        <div="post" action="" class="form-sample">
          <p class="card-description">
            <?php echo $answer['data']['subtitle']; ?>
          </p>
          <div class="text-right">
            <div class="container" style="text-align: right;">
              <a><img src="/Aaapumac/src/views/assets/img/aaapumac.png" alt="Logo"></a>
            </div>
          </div>
          <h4>
            <center>FORMATO DE ENTREGA DE PEDIMENTOS <br> Modulo de Gestiones<br> (Exportación, Importación Ferrocarril
              y
              Tránsitos)</center>
          </h4>
          <!-- <?php //foreach ($answer['job'] as $j) : ?> --><br>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Patente:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" value="<?php //echo $j->getTitle(); ?>" />
                </div>

                <label class="col-sm-3 col-form-label">Agente Aduanal:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" value="<?php //echo $j->getVacancy(); ?>" />
                </div>

                <label class="col-sm-3 col-form-label">Agencia:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" value="<?php //echo $j->getVacancy(); ?>" />
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="row justify-content-end">
                <div class="col-auto">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Folio</span>
                    <input type="text" class="form-control" aria-label="Sizing example input"
                      aria-describedby="inputGroup-sizing-sm">
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Vacantes</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" value="<?php //echo $j->getVacancy(); ?>" />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nombre de Ejecutivo:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" value="<?php //echo $j->getTitle(); ?>" />
                </div>

                <label class="col-sm-3 col-form-label">Correo electronico:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" value="<?php //echo $j->getVacancy(); ?>" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Fecha:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" value="<?php //echo $j->getTitle(); ?>" />
                </div>

                <label class="col-sm-3 col-form-label">Telefono:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" value="<?php //echo $j->getVacancy(); ?>" />
                </div>
              </div><br>
            </div>
            <table class="table table-hover">
              <thead class="thead-light text-center">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Pedimento</th>
                  <th scope="col">Tipo de Operación</th>
                  <th scope="col">Clave</th>
                  <th scope="col">CR</th>
                  <th scope="col" colspan="2">Resultados</th>
                  <th scope="col" colspan="2">Observaciones</th>
                </tr>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th scope="col" colspan="2">Motivo / Estatus</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $datos = [
                  ["numero" => 1, "pedimento" => "ABC123", "tipo_operacion" => "Importación", "clave" => "123456", "cr" => "7890", "resultado_v" => "V", "resultado_r" => "R", "motivo" => "Observación 1", "estatus" => "Estatus 1"],
                  ["numero" => 2, "pedimento" => "DEF456", "tipo_operacion" => "Exportación", "clave" => "789012", "cr" => "3456", "resultado_v" => "", "resultado_r" => "R", "motivo" => "Observación 2", "estatus" => "Estatus 2"]
                ];

                foreach ($datos as $dato) {
                  echo "<tr>";
                  echo "<td class='text-center'>" . $dato['numero'] . "</td>";
                  echo "<td class='text-center'>" . $dato['pedimento'] . "</td>";
                  echo "<td class='text-center'>" . $dato['tipo_operacion'] . "</td>";
                  echo "<td class='text-center'>" . $dato['clave'] . "</td>";
                  echo "<td class='text-center'>" . $dato['cr'] . "</td>";
                  echo "<td class='text-center'>" . $dato['resultado_v'] . "</td>";
                  echo "<td class='text-center'>" . $dato['resultado_r'] . "</td>";
                  echo "<td class='text-center'>" . $dato['motivo'] . "</td>";
                  echo "<td class='text-center'>" . $dato['estatus'] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          </form>
          <br><br><br>
          <div class="container px-4 text-center">
            <div class="row gx-5">
              <div class="col">
                <div class="p-3 border bg-light">FIRMA DE ADUANA</div>
              </div>
              <div class="col">
                <div class="p-3 border bg-light">DEPENDIENTE QUE RECIBE RESULTADO</div>
              </div>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-6 text">
              <div class="form-group row">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nombre:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" />
                </div>

                <label class="col-sm-3 col-form-label">CD:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" />
                </div>

                <label class="col-sm-3 col-form-label">Fecha:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" />
                </div>

                <label class="col-sm-3 col-form-label">Hora:</label>
                <div class="col-sm-9">
                  <input type="int" class="form-control" />
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group row">
              <label class="col-lg-3 col-form-label">Responsabilidades</label>
            </div>
            <!-- </div>
              <div class="col-lg-12 grid-margin stretch-card"> -->
            <div class="form-group row">
              <div class="col-lg-12">
                <div cols="50" rows="15" class="form-control" id="editor" style="height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Gender</label>
              <div class="col-sm-9">
                <select class="form-control">
                  <option>Male</option>
                  <option>Female</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Date of Birth</label>
              <div class="col-sm-9">
                <input class="form-control" placeholder="dd/mm/yyyy" />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Category</label>
              <div class="col-sm-9">
                <select class="form-control">
                  <option>Category1</option>
                  <option>Category2</option>
                  <option>Category3</option>
                  <option>Category4</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Estatus</label>
              <div class="col-sm-4">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="statusRadios" id="statusRadios1" value="1">
                    <?php //if($j->getId_Status() == 1) echo 'checked' ?? ''; ?>>
                    Activo
                  </label>
                </div>
              </div>
              <div class="col-sm-5">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="statusRadios" id="statusRadios2" value="2">
                    <?php // if($j->getId_Status() == 2) echo 'checked' ?? ''; ?>>
                    Inactivo
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p class="card-description">
          Address
        </p>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Address 1</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" />
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">State</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Address 2</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" />
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Postcode</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">City</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" />
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Country</label>
              <div class="col-sm-9">
                <select class="form-control">
                  <option>America</option>
                  <option>Italy</option>
                  <option>Russia</option>
                  <option>Britain</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <?php //endforeach; ?>
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
        <button type="button" class="btn btn-light mb-2" onclick="location.href='/'">Cancelar</button>
      </div>
    </div>
  </div>
</div>