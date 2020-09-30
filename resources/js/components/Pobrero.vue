<template>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <template v-if="accion=='listar'">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trabajadores</a></li>
                <li class="breadcrumb-item active">Obrero</li>
              </ol>
            </template>
            <template v-if="accion=='registrar'">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">Trabajadores</li>
                <li class="breadcrumb-item active"><a href="#" @click.prevent="accion='listar'; resetearInputs()">Obrero</a></li>
                <li class="breadcrumb-item">Registrar</li>
              </ol>
            </template>
            <template v-if="accion=='ver'">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">Trabajadores</li>
                <li class="breadcrumb-item active"><a href="#" @click.prevent="accion='listar'; resetearInputs()">Obrero</a></li>
                <li class="breadcrumb-item">Consultar</li>
              </ol>
            </template>
            <template v-if="accion=='editar'">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">Trabajadores</li>
                <li class="breadcrumb-item active"><a href="#" @click.prevent="accion='listar'; resetearInputs()">Obrero</a></li>
                <li class="breadcrumb-item">Editar</li>
              </ol>
            </template>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" v-if="accion=='listar'">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <button @click="accion='registrar'; resetearInputs();" type="button" class="btn btn-light">
                  <i class="fa fa-plus"></i>&nbsp;Nuevo
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group row">
                  <div class="col-md-4">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <a href="#" ><i aria-hidden="true" class='fa fa-search'></i></a>
                        </div>
                      </div>
                      <input @keyup="listarEmpleado(pagination.current_page, busqueda, criterio)" v-model="busqueda" id="search" type="text" class="form-control" placeholder="Busqueda">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group">
                      <select @change="listarEmpleado(1, busqueda, criterio)" class="form-control" v-model="criterio">
                        <option value="" selected>Todos</option>
                        <option value="Fijo">Fijos</option>
                        <option value="Contratado">Contratados</option>
                        <option value="Pensionado">Pensionados</option>
                        <option value="Jubilado">Jubilados</option>
                        <option value="Inactivo">Inactivos</option>
                      </select>
                    </div>
                  </div>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
                    <th>Acción</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr v-for="empleado in arrayempleado" :key="empleado.id">
                      <td v-text="empleado.nombres"></td>
                      <td v-text="empleado.apellidos"></td>
                      <td v-text="'Obrero °'+empleado.grado"></td>
                      <td>
                        <a href="#" @click="accion='ver'; editarEmpleado(empleado.id)"><i class="far fa-eye" ></i></a>
                        <a href="#" @click="accion='editar'; editarEmpleado(empleado.id)"><i class="fas fa-edit"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
                
                  <ul class="pagination btn-group mr-2 mt-4" role="group" aria-label="First group">
                    <li v-if="pagination.current_page > 1">
                      <button type="button" class="btn btn-light" @click.prevent="cambioPagina(pagination.current_page - 1)">Atras</button>
                    </li>
                    <li v-for="page in pageNumber" :key="page" :class="[page == 1 ? 'active' : '']">
                      <button @click.prevent="cambioPagina(page)" :class="[page == isActive ? 'btn-primary' : 'btn-light']" v-text="page" type="button" class="btn"></button>
                    </li>
                    <li v-if="pagination.current_page < pagination.last_page">
                      <button type="button" class="btn btn-light" @click.prevent="cambioPagina(pagination.current_page + 1)">Siguiente</button>
                    </li>
                  </ul>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
      <div class="container-fluid" v-if="accion=='registrar' || accion=='editar'">
        <!-- Formulario de registro de -->
          <!-- card datos personales -->      
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Datos personales</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div> 
            <!-- /.card-header -->
            <div class="card-body">  
              <div class="row">
                <div class="col-md-4 mb-2 form-group">
                  <label for="name">Nombres</label>
                  <input v-model="nombres" @change="validarCampo(nombres, 'name')" type="text" class="form-control" id="name" required>
                  <div class="invalid-feedback">
                          *Este campo es requerido
                  </div>
                </div>
                <div class="col-md-4 mb-2 form-group">
                  <label for="lastname">Apellidos</label>
                  <input v-model="apellidos" @change="validarCampo(apellidos, 'lastname')" type="text" class="form-control" id="lastname" required>
                  <div class="invalid-feedback">
                          *Este campo es requerido
                  </div>
                </div>
                <div class="col-md-4 mb-2 form-group">
                  <label for="sexo">Sexo</label>
                  <select v-model="sexo" @change="validarCampo(sexo, 'sexo')" id="sexo" name="sexo" class="form-control" required>
                    <option disabled selected>Seleccionar</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                  </select>
                </div>
                <div class="col-md-4 mb-2 form-group">
                  <label for="cedula">Cédula</label>	
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <select v-model="pre_cedula">
                          <option value="V-">V-</option>
                          <option value="E-">E-</option>
                        </select>
                      </div>
                    </div>
                    <input v-model="cedula" @keyup="validarCampo(cedula, 'cedula')" id="cedula" type="number" name="cedula" class="form-control" min="4000000" required>
                  </div>
                  <div class="invalid-feedback">
                          *Este campo es requerido
                  </div>
                </div>
                <div class="col-md-4 mb-2 form-group">
                  <label for="nacimiento">Fecha de nacimiento</label>
                  <input v-model="fecha_nacimiento" @change="validarCampo(fecha_nacimiento, 'nacimiento')" type="date" min="1930-01-01" max="2000-01-01" class="form-control" id="nacimiento" name="fecha_na" required>
                  <div class="invalid-feedback">
                          *Fecha invalida
                  </div>
                </div>
              </div> 
              <div class="row">
                <div class="col-md-4 mb-2 form-group">
                  <label for="correo">Correo electrónico</label>
                  <input v-model="correo" @change="validarCampo(correo, 'correo')" type="email" class="form-control" id="correo" required>
                  <div class="invalid-feedback">
                          *Este campo es requerido
                  </div>
                </div>
                <div class="col-md-4 mb-2 form-group">
                  <label for="telefono">Número de teléfono</label>	
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <select v-model="pre_telefono">
                          <option value="0414-">0414-</option>
                          <option value="0424-">0424-</option>
                          <option value="0416-">0416-</option>
                          <option value="0426-">0426-</option>
                          <option value="0412-">0412-</option>
                          <option value="0285-">0285-</option>
                        </select>
                      </div>
                    </div>
                    <input v-model="telefono" @keyup="validarCampo(telefono, 'telefono')" id="telefono" type="number" class="form-control" required>
                  </div>
                  <div class="invalid-feedback">
                          *Este campo es requerido
                  </div>
                </div>
              </div> 
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
          </div>
          <!-- /.card --> 
          <!-- card datos laborales -->
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Datos de Empleado</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div> 
            <!-- /.card-header -->
            <div class="card-body">  
              <div class="row">
                <div class="col-md-2 mb-2 form-group">
                  <label for="grado">grado</label>
                  <select v-model="grado" @change="validarCampo(grado, 'grado')" id="grado" class="form-control" required>
                    <option disabled selected>Seleccionar</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="5">6</option>
                    <option value="5">7</option>
                  </select>
                </div>
                <div class="col-md-4 mb-2 form-group">
                  <label for="fecha_ingreso">Fecha de ingreso</label>
                  <input v-model="fecha_ingreso" @change="validarCampo(fecha_ingreso, 'fecha_ingreso'); calculaAñosServicio()" type="date" min="2004-01-01" max="2021-01-01" class="form-control" id="fecha_ingreso" name="fecha_na" required>
                  <div class="invalid-feedback">
                          *Fecha invalida
                  </div>
                </div>
                <div class="col-md-4 mb-2 form-group">
                  <label for="estadoEmpleado">Estado</label> 
                  <select v-model="estadoEmpleado" id="estadoEmpleado" class="form-control" required>
                    <option value="Fijo">Fijo</option>
                    <option value="Contratado">Contratado</option>
                    <option value="Pensionado">Pensionado</option>
                    <option value="Jubilado">Jubilado</option>
                    <option value="Inactivo">Inactivo</option>
                  </select>
                </div>      
              </div>  
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
          </div>
          <!-- /.card --> 
          <!-- card datos de salario-->      
          <div class="card card-default collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Datos de Salario</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
              </div>
            </div> 
            <!-- /.card-header -->
            <div class="card-body">  
              <div class="row">
                <table class="table table-bordered table-striped table-sm">
                                
                  <tbody>
                    <tr style="background-color: #CEEFCF5">
                      <td colspan="4">
                        <strong>Salario tabla para Obrero
                        <span v-if="grado!='Seleccionar'" v-text="grado+':'"></span>
                        </strong>
                      </td>
                      <td colspan="2">
                        <span>
                          <p  v-text="formatoDivisa(salarioTabla)"></p>
                        </span>
                        
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                        <strong>Años de Servicio: </strong>
                      </td>
                      <td colspan="2">
                        <span v-text="añosServicio"></span>
                      </td>
                    </tr>
                  </tbody>

                  <tbody>
                    <tr style="background-color: #343a40">
                      <td colspan="6" align="center" class="text-light">BENEFICIOS</td>
                    </tr>
                    <tr v-for="beneficio in beneficiosEmpleado" :key="beneficio.id">
                      <td colspan="4" v-text="beneficio.concepto"></td>
                      <td colspan="2" class="beneficio" v-if="beneficio.tipo_valor == 'U.T'" v-text="formatoDivisa(beneficio.valor*UT)"></td>
                      <td colspan="2" class="beneficio" v-if="beneficio.tipo_valor == '%' && beneficio.concepto != 'Prima de Antiguedad'" v-text="formatoDivisa(parseFloat(beneficio.valor*salarioTabla/100).toFixed(2))"></td>
                      <td colspan="2" class="beneficio" v-if="beneficio.concepto == 'Prima de Antiguedad'" v-text="formatoDivisa((TotalprimaAntiguedad).toFixed(2))"></td>
                    </tr>
                    <tr v-if="beneficiosEmpleado.length != 0">
                      <td colspan="4"><strong>Total de Beneficios:</strong></td>
                      <td colspan="2" v-text="formatoDivisa(sumaTotal('asig').toFixed(2))"></td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center">
                        <button @click="listarBeneficios()" class="btn btn-light" data-toggle="modal" data-target="#ModalBeneficios"><i class="fa fa-plus"></i>&nbsp;Agregar/Quitar</button>
                      </td>
                    </tr>
                  </tbody>
                  <tbody>
                    <tr style="background-color: #343a40">
                      <td colspan="6" align="center" class="text-light">DESCUENTOS</td>
                    </tr>
                    <tr v-for="descuento in descuentosEmpleado" :key="descuento.id">
                      <td colspan="4" v-text="descuento.concepto"></td>
                      <td colspan="2" v-text="formatoDivisa(parseFloat(descuento.porcentaje*salarioTabla/100).toFixed(2))"></td>
                    </tr>
                    <tr v-if="beneficiosEmpleado.length != 0">
                      <td colspan="4"><strong>Total de Deducciones:</strong></td>
                      <td colspan="2" v-text="formatoDivisa(sumaTotal('deduc'))"></td>
                    </tr>
                    <tr >
                      <td colspan="6" align="center">
                        <button @click="listarDescuentos()" class="btn btn-light" data-toggle="modal" data-target="#ModalDescuentos"><i class="fa fa-plus"></i>&nbsp;Agregar/Quitar</button>
                      </td>
                    </tr>
                  </tbody>
                  <tbody>
                    <tr style="background-color: #CEEFCF5">
                      <td colspan="4"><strong>Salario normal mensual</strong></td>
                      <td colspan="2" v-text="formatoDivisa(parseFloat(totalBene+salarioTabla).toFixed(2))"></td>
                    </tr>
                    <tr style="background-color: #FFF !important">
                      <td colspan="6">
                        <div class="form-group form-check">
                          <input type="checkbox" class="form-check-input" id="confirm_sal">
                          <label class="form-check-label" for="confirm_sal">Confirmo que he ingresado los datos salariales correctamente</label>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>  
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
          </div>
          <!-- /.card -->
          <template v-if="accion=='registrar'">
            <button @click="registrar()" type="button" class="btn btn-primary btn-lg">Registrar</button>
          </template>
          <template v-if="accion=='editar'">
            <button @click="actualizarEmpleado()" type="button" class="btn btn-primary btn-lg">Actualizar</button>
          </template>
          
      </div><!-- /.container-fluid -->
      <div class="container-fluid" v-if="accion=='ver'">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <strong><p v-text="nombres+' '+apellidos+'   '+pre_cedula+cedula"></p></strong>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table1" class="table">
                  <thead>
                    <tr>
                      <td><strong>Datos personales</strong></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr >
                      <td v-text="'Sexo: '+sexo"></td>
                      <td v-text="'Correo electrónico: '+correo"></td>
                      <td v-text="'Número de teléfono: '+pre_telefono+telefono"></td>
                    </tr>
                    <tr >
                      <td v-text="'Fecha de nacimiento: '+fecha_nacimiento"></td>
                      <td> </td>
                      <td> </td>
                    </tr>
                  </tbody>
                </table>
                <table id="table2" class="table">
                  <thead>
                    <tr >
                      <td><strong>Datos de empleado</strong></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr >
                      <td v-text="'Cargo: Obrero'+grado"></td>
                    </tr>
                    <tr >
                      <td v-text="'Estado: '+estadoEmpleado"></td>
                      <td v-text="'Fecha de ingreso: '+fecha_ingreso"></td>
                      <td> </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
      <!-- Button trigger modal -->
    </section>
    <!-- /.content -->
    <!-- Modal Beneficios-->
    <div class="modal fade" id="ModalBeneficios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Beneficio</th>
                          <th>Cantidad</th>
                          <th>Estado</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="beneficio in arrayBeneficios" :key="beneficio.id">
                          <td v-text="beneficio.concepto"></td>
                          <td v-text="beneficio.valor+beneficio.tipo_valor"></td>
                          <td>
                            <template v-if="id_beneficiosAgregados.includes(beneficio.id)">
                              <a href="#" @click="retirarBeneficio(beneficio.id)">
                                <i class="fa fa-check text-success"></i>
                              </a>
                            </template>
                            <template v-else-if="beneficio.concepto=='Prima de Antiguedad'"> 
                              <a href="#" @click="agregarBeneficio({concepto:beneficio.concepto, tipo_valor:beneficio.tipo_valor, valor:beneficio.valor}, beneficio.id); primaAntiguedad()">
                                <i class="fa fa-plus text-dark"></i>
                              </a>
                            </template>
                            <template v-else>
                              <a href="#" @click="agregarBeneficio({concepto:beneficio.concepto, tipo_valor:beneficio.tipo_valor, valor:beneficio.valor}, beneficio.id)">
                                <i class="fa fa-plus text-dark"></i>
                              </a>
                            </template>
                          </td>
                        </tr>
                      </tbody>
                    </table> 
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- /.Modal -->
    <!-- Modal Descuentos-->
    <div class="modal fade" id="ModalDescuentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Concepto</th>
                          <th>Tipo</th>
                          <th>Valor</th>
                          <th>Estado</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="descuento in arrayDescuentos" :key="descuento.id">
                          <td v-text="descuento.concepto"></td>
                          <td v-text="descuento.tipo"></td>
                          <td v-text="descuento.porcentaje+'%'"></td>
                          <td>
                            <template v-if="id_descuentosAgregados.includes(descuento.id)">
                              <a href="#" @click="retirarDescuento(descuento.id)">
                                <i class="fa fa-check text-success"></i>
                              </a>
                            </template>
                            <template v-else>
                              <a href="#" @click="agregarDescuento({concepto:descuento.concepto, tipo:descuento.tipo, porcentaje:descuento.porcentaje}, descuento.id)">
                                <i class="fa fa-plus text-dark"></i>
                              </a>
                            </template>
                          </td>
                        </tr>
                      </tbody>
                    </table> 
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- /.Modal -->
  </div>
  <!-- /.content-wrapper -->

</template>
<script>
    export default {
        data() {
          return {
            nombres: "",
            apellidos: "",
            sexo: "Seleccionar",
            pre_cedula: "V-",
            cedula: "",
            correo: "",
            pre_telefono: "0414-",
            telefono: "",
            fecha_nacimiento: "",
            grado: "Seleccionar",
            fecha_ingreso: "",
            tipoPersonal: "Obrero",
            estadoEmpleado: "Contratado",
            arrayempleado: [],
            pagination: {
                "total": 0,
                "current_page": 0,
                "per_page": 0,
                "last_page": 0,
                "from": 0,
                "to": 0
              },
            accion: 'listar',
            id_salario: 2,
            salarioTabla: 0,
            UT: '',
            arrayBeneficios: [],
            arrayDescuentos: [],
            beneficiosEmpleado: [],
            totalBene: 0,
            descuentosEmpleado: [],
            id_beneficiosAgregados:[],
            id_descuentosAgregados: [],
            añosServicio: 0,
            TotalprimaAntiguedad:0,
            error: [],
            id_empleado: "",
            id_persona: "",
            busqueda: "",
            criterio: ""
          }
        },
        computed:{
          
          isActive: function (){
            return this.pagination.current_page;
          },
          pageNumber: function(){

            let me = this;

            if(!me.pagination.to){
              return [];
            }

            var from = me.pagination.current_page - 2; //TODO offset

            if (from < 1) {
              from = 1;
            };

            var to = from + (2 * 2); //TODO

            if (to >= me.pagination.last_page) {
              to = me.pagination.last_page;
            };

            var pagesArray = [];

            while(from <= to){
              pagesArray.push(from);
              from++;
            };

            return pagesArray;
          }
        },
        methods: {
          listarEmpleado(page, busqueda, criterio){
            let me=this;
                var url= '/empleados?page='+page+'&busqueda='+busqueda+'&criterio='+criterio+'&tipo='+me.tipoPersonal;
                axios.get(url).then(function (response) {
                    var respuesta= response.data.empleados.data;
                    me.arrayempleado = respuesta;
                    me.pagination = response.data.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
          },
          registrar(){
            let me = this;
            if(me.validarForm()){

              swal.fire({
                title: '¿Desea continuar con el registro?',
                text: "Una vez registrado, el empleado no podrá ser eliminado de la base de datos",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar'
              }).then((result) => {
                if (result.value) {
                  let me = this;
                  let url = '/empleados/agregarNuevo';
                  axios.post(url, {
                    nombres:me.nombres,
                    apellidos:me.apellidos,
                    sexo:me.sexo,
                    cedula:me.pre_cedula+me.cedula,
                    correo:me.correo,
                    telefono:me.pre_telefono+me.telefono,
                    nacimiento:me.fecha_nacimiento,
                    grado: me.grado,
                    fecha_ingreso: me.fecha_ingreso,
                    departamento: me.departamento,
                    grado_instruccion: me.grado_instruccion,
                    estado: me.estadoEmpleado,
                    beneficios: me.id_beneficiosAgregados,
                    descuentos: me.id_descuentosAgregados,
                    tipo: me.tipoPersonal
                  }).then(function(response){
                    if(response.data.respuesta){
                      Vue.toasted.error( 'Empleado existente, verifique los datos ingresados', {duration:2000, className:['alert', 'alert-danger']})
                    }else{
                      swal.fire(
                        'Empleado agregado exitosamente',
                        '',
                        'success'
                      )
                      me.accion = "listar";
                      me.listarEmpleado(1, me.busqueda, me.criterio);
                      me.resetearInputs();
                    } 
                  }).catch(function(error){
                    console.log(error)
                  });
                }else return;
              })


            };
          },
          editarEmpleado(id){
            let me = this;
            let url = '/empleados/editarEmpleado/'+id;
            axios.get(url).then(function(response){
              let empleado = response.data.empleado[0];   
              me.beneficiosEmpleado = response.data.beneficios;
              me.descuentosEmpleado = response.data.descuentos;
              
              for (var i = 0; i < me.beneficiosEmpleado.length; i++) {
                    me.id_beneficiosAgregados.push(me.beneficiosEmpleado[i].id);
                  }

              for (var i = 0; i < me.descuentosEmpleado.length; i++) {
                    me.id_descuentosAgregados.push(me.descuentosEmpleado[i].id);
                  }

              let cedula = empleado.cedula;
              me.nombres= empleado.nombres;
              me.apellidos= empleado.apellidos;
              me.sexo= empleado.sexo;
              me.pre_cedula= empleado.cedula.substring(0, 2);
              me.cedula= empleado.cedula.substring(2);
              me.correo= empleado.correo;
              me.pre_telefono= empleado.telefono.substring(0, 5);
              me.telefono= empleado.telefono.substring(5);
              me.fecha_nacimiento= empleado.nacimiento;
              me.grado= empleado.grado;
              me.nivel= empleado.nivel;
              me.fecha_ingreso= empleado.fechaIngreso;
              me.departamento= empleado.departamento;
              me.grado_instruccion= empleado.instruccion;
              me.estadoEmpleado= empleado.estado;
              me.id_empleado= empleado.id_empleado;
              me.id_persona= empleado.id_persona;
              me.calculaAñosServicio();

              me.datoSalario();
              
              
            }).catch(function(error){
              console.log(error);
            });
          },
          actualizarEmpleado(){
            let me = this;
            if(me.validarForm()){
                let me = this;
                let url = '/empleados/actualizarEmpleado';
                axios.put(url, {
                  nombres:me.nombres,
                  apellidos:me.apellidos,
                  sexo:me.sexo,
                  cedula:me.pre_cedula+me.cedula,
                  correo:me.correo,
                  telefono:me.pre_telefono+me.telefono,
                  nacimiento:me.fecha_nacimiento,
                  grado: me.grado,
                  nivel: me.nivel,
                  fecha_ingreso: me.fecha_ingreso,
                  departamento: me.departamento,
                  grado_instruccion: me.grado_instruccion,
                  estado: me.estadoEmpleado,
                  beneficios: me.id_beneficiosAgregados,
                  descuentos: me.id_descuentosAgregados,
                  id_persona: me.id_persona,
                  id_empleado: me.id_empleado 
                }).then(function(response){
                  
                  swal.fire(
                      'Actualizado exitosamente',
                      '',
                      'success');

                    me.accion = "listar";
                    me.listarEmpleado(1, me.busqueda, me.criterio);
                    me.resetearInputs();
                   
                }).catch(function(error){
                  console.log(error)
                });
            };
          },
          validarForm(){
            const inputs = document.getElementsByClassName('form-control');
            //Validar todos los campos vacios
              this.error = [];
              for (let i = 0; i < inputs.length; i++) {               
                const element = inputs[i];
                if(!element.value || element.value == "Seleccionar"){
                  element.classList.add('is-invalid');
                  this.error.push(element.id);
                }else{
                  element.classList.remove('is-invalid');
                  element.classList.add('is-valid');
                };                
              };

           //console.log(this.error);
           if(!this.error.length && this.validarDatosSalario()){return true}
          },
          validarCampo(campo, id){
            //Validar campos al escribir o cambiar
            
            this.error = [];
            if(id && campo != ""){
              const input = document.getElementById(id);
              input.classList.remove('is-invalid');
              input.classList.add('is-valid');
              switch(id){
                case "cedula":
                    if(campo.length < 7 || campo.length > 8){input.classList.add('is-invalid');
                      this.error.push(input.id);
                    }else{
                      input.classList.remove('is-invalid')
                      input.classList.add('is-valid')
                    }
                  break;
                  case "telefono":
                    if(campo.length != 7){input.classList.add('is-invalid');
                      this.error.push(input.id);
                    }else{
                      input.classList.remove('is-invalid')
                      input.classList.add('is-valid')
                    }
                  break;
                  case "nacimiento":
                    if(input.value < input.min || input.value > input.max){input.classList.add('is-invalid')
                      this.error.push(input.id);
                    }
                    else{
                      input.classList.remove('is-invalid')
                      input.classList.add('is-valid')
                    }
                  break;
                  case "fecha_ingreso":
                    if(input.value < input.min || input.value > input.max){
                      input.classList.add('is-invalid');
                      this.error.push(input.id);
                    }
                    else{
                      input.classList.remove('is-invalid');
                      input.classList.add('is-valid');
                    }
                  break;
                  case "grado":
                    this.datoSalario();
                  break;
              }; 
            };
           //console.log(this.error);
          },
          validarDatosSalario(){
            let checkStatus = document.getElementById('confirm_sal').checked;
            if (checkStatus) {
              return true;
            }else{
              let cardElement = document.getElementsByClassName('card-default');
                for (var i = 0; i < 2; i++) {
                  if (!cardElement[i].classList.contains('collapsed-card')) {
                    cardElement[i].classList.add('collapsed-card')
                  }       
                }

                cardElement[2].classList.remove('collapsed-card');
                //Cambiar icono de minus a plus en la cabecera de la carta
              let elementIco = document.getElementsByClassName('fas');
                for (var i = 11; i < 14; i++) {
                  if (elementIco[i].classList.contains('fa-minus')) {
                    elementIco[i].classList.remove('fa-minus');
                    elementIco[i].classList.add('fa-plus');
                  }else{
                    elementIco[i].classList.remove('fa-plus');
                    elementIco[i].classList.add('fa-minus');
                  }
                }

                Vue.toasted.info( 'Confirmar datos de salario del empleado', {duration:2000});
            }
          },
          datoSalario(){

              let me = this;

              if (me.grado!='Seleccionar') {
                  let url = 'empleados/salarioTabla';
                  axios.post(url, {id_salario:me.id_salario}).then(function(response){
                  let grado = me.grado;
                  let nivel = parseInt(me.nivel)-1;
                  let salario = JSON.parse(response.data.tabulador);
                  salario = salario[grado];
                  me.salarioTabla = salario;
                  me.UT = response.data.UT;
                
                }).catch(function(error){
                  console.log(error);
                  return false;
                });

                return true;
              }else{
                return false;
              }
          },
          resetearInputs(){
            let me = this;

            me.nombres="";
            me.apellidos="";
            me.sexo="";
            me.pre_cedula="";
            me.cedula="";
            me.correo="";
            me.pre_telefono="";
            me.telefono="";
            me.fecha_nacimiento="";
            me.grado="Seleccionar";
            me.nivel="Seleccionar";
            me.fecha_ingreso="";
            me.departamento="Seleccionar";
            me.grado_instruccion="Seleccionar";
            me.sexo= "Seleccionar"
            me.pre_cedula= "V-"
            me.pre_telefono= "0414-"
            me.salarioTabla = 0;
            me.añosServicio = 0;
            me.TotalprimaAntiguedad= 0;
            me.totalBene = 0;
            me.id_beneficiosAgregados= [];
            me.id_descuentosAgregados= [];
            me.beneficiosEmpleado= [];
            me.descuentosEmpleado= [];
          },
          listarBeneficios(){
            let me = this;
            let url = 'empleados/beneficios';
            axios.get(url).then(function(response){
              me.arrayBeneficios = response.data.beneficios;
            }).catch(function(error){
              console.log(error);
            })
          },
          listarDescuentos(){
            let me = this;
            let url = 'empleados/descuentos';
            axios.get(url).then(function(response){
              me.arrayDescuentos = response.data.descuentos;
            }).catch(function(error){
              console.log(error);
            })
          },
          agregarBeneficio(beneficio, id){
            this.beneficiosEmpleado.push(beneficio);
            this.id_beneficiosAgregados.push(id);
            this.listarBeneficios();
          },
          retirarBeneficio(id){
            let beneficio_index = this.id_beneficiosAgregados.indexOf(id);
            this.id_beneficiosAgregados.splice(beneficio_index, 1);
            this.beneficiosEmpleado.splice(beneficio_index, 1);
            this.listarBeneficios();
          },
          agregarDescuento(descuento, id){
            this.descuentosEmpleado.push(descuento);
            this.id_descuentosAgregados.push(id)
            this.listarDescuentos();
          },
          retirarDescuento(id){
            let descuento_index = this.id_descuentosAgregados.indexOf(id);
            this.id_descuentosAgregados.splice(descuento_index, 1);
            this.descuentosEmpleado.splice(descuento_index, 1);
            this.listarDescuentos();
          },
          formatoDivisa(number){
           let monto = new Intl.NumberFormat('en-US').format(number);
           return monto;
          },
          primaAntiguedad(){

            //Calcula la prima de antiguedad
            let me = this;
            let total = 0;
            for (var i = 0; i < me.beneficiosEmpleado.length; i++) {
                  var num = 0;
                  if (me.beneficiosEmpleado[i].tipo_valor == 'U.T') {
                    num = me.beneficiosEmpleado[i].valor*me.UT;
                  }else if(me.beneficiosEmpleado[i].tipo_valor == '%' && me.beneficiosEmpleado[i].concepto != 'Prima de Antiguedad'){
                    num = me.beneficiosEmpleado[i].valor*me.salarioTabla/100;
                  } 

                   total += parseFloat(num);
                };
                
                let primaMonto = (((total+me.salarioTabla)*2)/100)*me.añosServicio;
                
                me.TotalprimaAntiguedad = primaMonto;       
          },
          calculaAñosServicio(){
            //Calcula los años de antiguedad a partir de la fecha de ingreso
            let ingreso = this.fecha_ingreso;
            let me = this;
            ingreso = new Date(ingreso);
            let actual = new Date();

            let año = ingreso.getFullYear();
            let mes = ingreso.getMonth(); 

            let antiguedad = actual.getFullYear()-año;
            if (mes >= actual.getMonth()  && antiguedad != 0) {
              antiguedad--;
            };
            me.añosServicio=antiguedad;
          },
          sumaTotal(suma){
            let me = this;
            
            if (suma=='asig') {
                let totalBene = 0;
                for (var i = 0; i < me.beneficiosEmpleado.length; i++) {
                  var bene = 0;
                  if (me.beneficiosEmpleado[i].tipo_valor == 'U.T') {
                    bene = me.beneficiosEmpleado[i].valor*me.UT;
                  }else if(me.beneficiosEmpleado[i].tipo_valor == '%' && me.beneficiosEmpleado[i].concepto != 'Prima de Antiguedad'){
                    bene = me.beneficiosEmpleado[i].valor*me.salarioTabla/100;
                  } 
                   totalBene += parseFloat(bene);
                };
               return me.totalBene = totalBene + me.TotalprimaAntiguedad;
                  
            }else if(suma == 'deduc'){
              let totalDeduc = 0;
              let arrayDescuentos = me.descuentosEmpleado;
              for (var i = 0; i < arrayDescuentos.length; i++) {
                  var num = arrayDescuentos[i].porcentaje*me.salarioTabla/100;
                  totalDeduc += parseFloat(num);
                };
                return me.totalDeduc = totalDeduc;
            }
          },
          cambioPagina(page){
            this.pagination.current_page = page;
            this.listarEmpleado(page, this.busqueda, this.criterio);
          }   
        }, 
        mounted() {
          this.listarEmpleado(1, this.busqueda, this.criterio);

        }
    }
</script>
<style>
  .collapsed-card.card-body{
    display:none;
  }
  .collapsed-card.card-footer{
    display:none;
  }

</style>