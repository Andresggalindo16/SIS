<?php
$page_title = 'Agregar producto';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$all_categories = find_all('categories');
$all_photo = find_all('media');
?>
<?php
if (isset($_POST['add_product'])) {
  $req_fields = array('name', 'quantity', 'buy_price', 'sale_price');
  validate_fields($req_fields);
  if (empty($errors)) {
    $p_name  = remove_junk($db->escape($_POST['name']));
    /* $p_cat   = remove_junk($db->escape($_POST['product-categorie'])); */
    $p_qty   = remove_junk($db->escape($_POST['quantity']));
    $p_buy   = remove_junk($db->escape($_POST['buy_price']));
    $p_sale  = remove_junk($db->escape($_POST['sale_price']));
    $p_label = remove_junk($db->escape($_POST['label']));
    $p_satus_buy  = remove_junk($db->escape($_POST['status_buy']));
    $p_satus_sale = remove_junk($db->escape($_POST['status_sale']));
    $p_almacen = remove_junk($db->escape($_POST['almacen']));
    $p_deseado   = remove_junk($db->escape($_POST['deseado']));
    $p_stock_min = remove_junk($db->escape($_POST['stock_min']));
    $p_peso      = remove_junk($db->escape($_POST['peso']));
    $p_volumen   = remove_junk($db->escape($_POST['volumen']));
    $p_alto      = remove_junk($db->escape($_POST['alto']));
    $p_ancho     = remove_junk($db->escape($_POST['ancho']));
    $profundo    = remove_junk($db->escape($_POST['profundo']));
    $p_unidad_longitud = remove_junk($db->escape($_POST['unidad_longitud']));
    $p_unidad_volumen = remove_junk($db->escape($_POST['unidad_volumen']));
    $p_unidad_peso = remove_junk($db->escape($_POST['unidad_peso']));
    $p_tipo_producto = remove_junk($db->escape($_POST['tipo_producto']));
    $p_nota      = remove_junk($db->escape($_POST['nota']));
    $p_iva      = remove_junk($db->escape($_POST['iva']));
    
    if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }
    $date    = make_date();
    $query  = "INSERT INTO products (";
    $query .= " iva,name,quantity,buy_price,sale_price,media_id,date,label, status_buy,status_sale, deseado, stock_min, peso, volumen, alto, ancho, profundo, unidad_longitud, unidad_volumen, unidad_peso, tipo_producto, nota, almacen";
    $query .= ") VALUES (";
    $query .= " '{$p_iva}', '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$media_id}', '{$date}', '{$p_label}', 
                '{$p_satus_buy}', '{$p_satus_sale}', '{$p_deseado}', '{$p_stock_min}', '{$p_peso}', '{$p_volumen}', '{$p_alto}', '{$p_ancho}', '{$profundo}', '{$p_unidad_longitud}', '{$p_unidad_volumen}', '{$p_unidad_peso}', '{$p_tipo_producto}', 
                '{$p_nota}', '{$p_almacen}'";
    $query .= ")";
   /*  echo $query;
    exit; */
    /* $query .= " ON DUPLICATE KEY UPDATE name='{$p_name}'"; */
    if ($db->query($query)) {
      $session->msg('s', "Producto agregado exitosamente. ");
      redirect('add_product.php', false);
    } else {
      $session->msg('d', ' Lo siento, el registro falló.');
      redirect('product.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('add_product.php', false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Agregar producto</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-asterisk"></i>
                </span>
                <input disabled type="text" style="width:20%;" class="form-control" name="id" placeholder="Ref">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-th-large"></i>
                </span>
                <input type="text" class="form-control" name="name" placeholder="Descripción">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-tag"></i>
                </span>
                <input type="text" class="form-control" name="label" placeholder="codigo">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-list-alt"></i>
                </span>
                <select class="form-control" name="status_sale">
                  <option value="">Estado (venta)</option>
                  <option value="activo">Activa</option>
                  <option value="inactiva">Inactiva</option>
                  <option value="no aplica">No aplica</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-usd"></i>
                </span>
                <select class="form-control" name="status_buy">
                  <option value="">Estado (compra)</option>
                  <option value="En compra">En compra</option>
                  <option value="Fuera de compra">Fuera de compra</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-folder-close"></i>
                </span>
                <!-- cambio de name -->
                <input type="text" class="form-control" name="almacen" placeholder="Almacen">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-usd"></i>
                </span>
                <!-- cambio de name -->
                <select class="form-control" name="iva"> 
                  <option value="">Aplica IVA</option>
                  <option value="si">SI</option>
                  <option value="no">NO</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                    </span>
                    <input type="number"  min="1" pattern="^[0-9]+" class="form-control" name="quantity" placeholder="Cantidad">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </span>
                    <input type="number" class="form-control" name="buy_price" placeholder="Precio de compra">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </span>
                    <input type="number" class="form-control" name="sale_price" placeholder="Precio de venta">
                  </div>
                </div>
              </div>
            </div>
            <!-- Hace falta meterlo en la BD -->
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-check"></i>
                    </span>
                    <input type="number" class="form-control" name="deseado" placeholder="Stock Deseado">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class=" glyphicon glyphicon-flag"></i>
                    </span>
                    <input type="number" class="form-control" name="stock_min" placeholder="Stock minimo">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-arrow-down"></i>
                    </span>
                    <input type="number" class="form-control" name="peso" placeholder="Peso">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-info-sign"></i>
                    </span>
                    <select class="form-control" name="unidad_peso">
                      <option value="">Unidad</option>
                      <option value="Kilo">Kilogramo</option>
                      <option value="Gramo">Gramo</option>
                      <option value="Tonelada">Tonelada</option>
                      <option value="Miligramos">Miligramos</option>
                      <option value="Libra">Libra</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-tint"></i>
                    </span>
                    <input type="number" class="form-control" name="volumen" placeholder="Volumen">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-info-sign"></i>
                    </span>
                    <select class="form-control" name="unidad_volumen">
                      <option value="">Unidad</option>
                      <option value="no aplica">no aplica</option>
                      <option value="cm3">Centimetro Cúbico</option>
                      <option value="m3">Metro Cúbico</option>
                      <option value="Onza">Onza</option>
                      <option value="Galon">Galón</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-resize-vertical"></i>
                    </span>
                    <input type="number" class="form-control" name="alto" placeholder="Longitud Alto">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-resize-horizontal"></i>
                    </span>
                    <input type="number" class="form-control" name="ancho" placeholder="Longituda Ancho">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class=" glyphicon glyphicon-resize-full"></i>
                    </span>
                    <input type="number" class="form-control" name="profundo" placeholder="Longitud Profunda">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-info-sign"></i>
                    </span>
                    <select class="form-control" name="unidad_longitud">
                      <option value="">Unidad de medida</option>
                      <option value="Metros">m</option>
                      <option value="Centimetros">cm</option>
                      <option value="Milimetros">mm</option>
                      <option value="Pie">pie</option>
                      <option value="Pulgada">pulgada</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-tags"></i>
                </span>
                <select class="form-control" name="tipo_producto">
                  <option value="natural_producto">Naturaleza del Producto</option>
                  <option value="materia_prima">Materia Prima</option>
                  <option value="producto">Producto</option>
                </select>
              </div>

            </div>            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-th-large"></i>
                </span>
                <textarea type="text" class="form-control" name="nota" placeholder="Nota Adicional"></textarea>              
              </div>
            </div>
            


            <button type="submit" name="add_product" class="btn btn-danger">Agregar producto</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>