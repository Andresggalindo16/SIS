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
  $req_fields = array('product-title', 'product-categorie', 'product-quantity', 'buying-price', 'saleing-price');
  validate_fields($req_fields);
  if (empty($errors)) {
    $p_name  = remove_junk($db->escape($_POST['product-title']));
    $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
    $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
    $p_buy   = remove_junk($db->escape($_POST['buying-price']));
    $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
    $p_label = remove_junk($db->escape($_POST['label']));
    $p_satus_buy  = remove_junk($db->escape($_POST['status_buy']));
    $p_satus_sale = remove_junk($db->escape($_POST['status_sale']));
    if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }
    $date    = make_date();
    $query  = "INSERT INTO products (";
    $query .= " name,quantity,buy_price,sale_price,media_id,date,label, status_buy,status_sale";
    $query .= ") VALUES (";
    $query .= " '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$media_id}', '{$date}', '{$p_label}', '{$p_satus_buy}', '{$p_satus_sale}'";
    $query .= ")";
    $query .= " ON DUPLICATE KEY UPDATE name='{$p_name}'";
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
                <input disabled type="text" style="width:20%;" class="form-control" name="product-title" placeholder="Ref">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-th-large"></i>
                </span>
                <input type="text" class="form-control" name="product-title" placeholder="Descripción">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-tag"></i>
                </span>
                <input type="text" class="form-control" name="label" placeholder="Etiqueta">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-list-alt"></i>
                </span>
                <select class="form-control" name="status_sale">
                  <option value="">Estado (venta)</option>
                  <option value="En Venta">Activa</option>
                  <option value="Sin Stock">Inactiva</option>
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
                  <option value="En Venta">En Venta</option>
                  <option value="Sin Stock">Sin Stock</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-folder-close"></i>
                </span>
                <input type="text" class="form-control" name="label" placeholder="Almacen">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-usd"></i>
                </span>
                <select class="form-control" name="status_buy">
                  <option value="">Aplica IVA</option>
                  <option value="En Venta">SI</option>
                  <option value="Sin Stock">NO</option>
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
                    <input type="number"  min="1" pattern="^[0-9]+" class="form-control" name="product-quantity" placeholder="Cantidad">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </span>
                    <input type="number" class="form-control" name="buying-price" placeholder="Precio de compra">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </span>
                    <input type="number" class="form-control" name="saleing-price" placeholder="Precio de venta">
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
                    <input type="number" class="form-control" name="product-quantity" placeholder="Stock Deseado">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class=" glyphicon glyphicon-flag"></i>
                    </span>
                    <input type="number" class="form-control" name="buying-price" placeholder="Stock minimo">
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
                    <input type="number" class="form-control" name="product-quantity" placeholder="Peso">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-info-sign"></i>
                    </span>
                    <select class="form-control" name="status_buy">
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
                    <input type="number" class="form-control" name="product-quantity" placeholder="Volumen">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-info-sign"></i>
                    </span>
                    <select class="form-control" name="status_buy">
                      <option value="">Unidad</option>
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
                    <input type="number" class="form-control" name="product-quantity" placeholder="Longitud Alto">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-resize-horizontal"></i>
                    </span>
                    <input type="number" class="form-control" name="buying-price" placeholder="Longituda Ancho">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class=" glyphicon glyphicon-resize-full"></i>
                    </span>
                    <input type="number" class="form-control" name="saleing-price" placeholder="Longitud Profunda">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-info-sign"></i>
                    </span>
                    <select class="form-control" name="status_buy">
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
                <select class="form-control" name="status_buy">
                  <option value="">Naturaleza del Producto</option>
                  <option value="">Materia Prima</option>
                  <option value="">Producto</option>
                </select>
              </div>

            </div>            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-th-large"></i>
                </span>
                <textarea type="text" class="form-control" name="product-title" placeholder="Nota Adicional"></textarea>              
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