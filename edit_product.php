<?php
$page_title = 'Editar producto';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
?>
<?php
$product = find_by_id('products', (int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if (!$product) {
  $session->msg("d", "Missing product id.");
  redirect('product.php');
}
?>
<?php
if (isset($_POST['product'])) {
  $req_fields = array();
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
    $p_iva    = remove_junk($db->escape($_POST['iva']));
    $p_unidad_longitud = remove_junk($db->escape($_POST['unidad_longitud']));
    $p_unidad_volumen = remove_junk($db->escape($_POST['unidad_volumen']));
    $p_unidad_peso = remove_junk($db->escape($_POST['unidad_peso']));
    $p_tipo_producto = remove_junk($db->escape($_POST['tipo_producto']));
    $p_nota      = remove_junk($db->escape($_POST['nota']));
    if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
      $media_id = '0';
    } else {
      $media_id = remove_junk($db->escape($_POST['product-photo']));
    }
    $query   = "UPDATE products SET";
    $query  .= " name = '{$p_name}' 
    ,quantity = '{$p_qty}' 
    ,buy_price = '{$p_buy}' 
    ,sale_price = '{$p_sale}' 
    ,media_id = '{$media_id}' 
    ,date = '{$date}' 
    ,label = '{$p_label}' 
    ,status_buy = '{$p_satus_buy}' 
    ,status_sale = '{$p_satus_sale}' 
    ,deseado = '{$p_deseado}' 
    ,stock_min = '{$p_stock_min}' 
    ,peso = '{$p_peso}' 
    ,volumen = '{$p_volumen}' 
    ,alto = '{$p_alto}' 
    ,ancho = '{$p_ancho}' 
    ,profundo = '{$profundo}' 
    ,unidad_longitud = '{$p_unidad_longitud}'
    ,unidad_volumen = '{$p_unidad_volumen}'
    ,unidad_peso = '{$p_unidad_peso}'
    ,tipo_producto = '{$p_tipo_producto}' 
    ,nota = '{$p_nota}'
    ,almacen = '{$p_almacen}'
    ,iva = '{$p_iva}' ";
    $query  .= " WHERE id ='{$product['id']}'";
    /* echo $query;
    exit; */
    $result = $db->query($query);
    if ($result && $db->affected_rows() === 1 || $db->affected_rows() === 0) {
      $session->msg('s', "Producto ha sido actualizado. ");
      redirect('product.php', false);
    } else {
      $session->msg('d', ' Lo siento, la actualización falló.');
      redirect('edit_product.php?id=' . $product['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('edit_product.php?id=' . $product['id'], false);
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
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Editar producto</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-7">
        <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
          <!-- <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']); ?>">
            </div>
          </div> -->
      <!--     <div class="form-group">
            <div class="row">
              <div class="col-md-8">
                <select class="form-control" name="product-categorie">
                  <option value="">Selecciona una categoría</option>
                  <?php foreach ($all_categories as $cat) : ?>
                    <option value="<?php echo (int)$cat['id']; ?>" <?php if ($product['categorie_id'] === $cat['id']) : echo "selected";
                                                                    endif; ?>>
                      <?php echo remove_junk($cat['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

            </div>
          </div> -->

          <!-- <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="qty">Cantidad</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                    </span>
                    <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="qty">Precio de compra</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </span>
                    <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($product['buy_price']); ?>">

                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="qty">Precio de venta</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="glyphicon glyphicon-usd"></i>
                    </span>
                    <input type="number" class="form-control" name="saleing-price" value="<?php echo remove_junk($product['sale_price']); ?>">
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-asterisk"></i>
              </span>
              <input disabled type="text" style="width:20%;" class="form-control" value="<?php echo ($product['id']); ?>" name="id" placeholder="Ref">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="name" value="<?php echo ($product['name']); ?>" placeholder="Descripción">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag"></i>
              </span>
              <input type="text" class="form-control" name="label" value="<?php echo ($product['label']); ?>" placeholder="Etiqueta">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-list-alt"></i>
              </span>
              <select class="form-control" name="status_sale">
                <option <?php echo $product['status_sale'] ==  '' ? 'selected' : '' ?> value="">Estado (venta)</option>
                <option <?php echo $product['status_sale'] ==  'activo' ? 'selected' : '' ?> value="activo">Activa</option>
                <option <?php echo $product['status_sale'] ==  'inactivo' ? 'selected' : '' ?> value="inactivo">Inactiva</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-usd"></i>
              </span>
              <select class="form-control" name="status_buy">
                <option <?php echo $product['status_buy'] ==  '' ? 'selected' : '' ?> value="">Estado (compra)</option>
                <option <?php echo $product['status_buy'] ==  'En Venta' ? 'selected' : '' ?> value="En Venta">En Venta</option>
                <option <?php echo $product['status_buy'] ==  'Sin Stock' ? 'selected' : '' ?> value="Sin Stock">Sin Stock</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-folder-close"></i>
              </span>
              <!-- cambio de name -->
              <input type="text" class="form-control" name="almacen" placeholder="Almacen" value="<?php echo $product['almacen'] ?>">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-usd"></i>
              </span>
              <!-- cambio de name -->
              <select class="form-control" name="iva">
                <option <?php echo $product['iva'] ==  '' ? 'selected' : '' ?> value="">Aplica IVA</option>
                <option <?php echo $product['iva'] ==  'si' ? 'selected' : '' ?> value="si">SI</option>
                <option <?php echo $product['iva'] ==  'no' ? 'selected' : '' ?> value="no">NO</option>
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
                  <input type="number" min="1" pattern="^[0-9]+" class="form-control" name="quantity" value="<?php echo ($product['quantity']);?>" placeholder="Cantidad">
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </span>
                  <input type="number" class="form-control" name="buy_price" value="<?php echo ($product['buy_price']);?>" placeholder="Precio de compra">
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </span>
                  <input type="number" class="form-control" name="sale_price" value="<?php echo ($product['sale_price']);?>" placeholder="Precio de venta">
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
                  <input type="number" class="form-control" name="deseado" value="<?php echo ($product['deseado']);?>" placeholder="Stock Deseado">
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class=" glyphicon glyphicon-flag"></i>
                  </span>
                  <input type="number" class="form-control" name="stock_min" value="<?php echo ($product['stock_min']);?>" placeholder="Stock minimo">
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
                  <input type="number" class="form-control" name="peso" value="<?php echo ($product['peso']);?>" placeholder="Peso">
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-info-sign"></i>
                  </span>
                  <select class="form-control" name="unidad_peso">
                    <option value="">Unidad</option>
                    <option <?php echo $product['unidad_peso'] ==  'Kilo' ? 'selected' : '' ?> value="Kilo">Kilogramo</option>
                    <option <?php echo $product['unidad_peso'] ==  'Gramo' ? 'selected' : '' ?> value="Gramo">Gramo</option>
                    <option <?php echo $product['unidad_peso'] ==  'Tonelada' ? 'selected' : '' ?> value="Tonelada">Tonelada</option>
                    <option <?php echo $product['unidad_peso'] ==  'Miligramos' ? 'selected' : '' ?> value="Miligramos">Miligramos</option>
                    <option <?php echo $product['unidad_peso'] ==  'Libra' ? 'selected' : '' ?> value="Libra">Libra</option>
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
                  <input type="number" class="form-control" name="volumen"  value="<?php echo ($product['volumen']);?>" placeholder="Volumen">
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-info-sign"></i>
                  </span>
                  <select class="form-control" name="unidad_volumen">
                    <option value="">Unidad</option>
                    <option <?php echo $product['unidad_volumen'] ==  'cm3' ? 'selected' : '' ?> value="cm3">Centimetro Cúbico</option>
                    <option <?php echo $product['unidad_volumen'] ==  'm3' ? 'selected' : '' ?> value="m3">Metro Cúbico</option>
                    <option <?php echo $product['unidad_volumen'] ==  'Onza' ? 'selected' : '' ?> value="Onza">Onza</option>
                    <option <?php echo $product['unidad_volumen'] ==  'Galon' ? 'selected' : '' ?> value="Galon">Galón</option>
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
                  <input type="number" class="form-control" name="alto" value="<?php echo ($product['alto']);?>" placeholder="Longitud Alto">
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-resize-horizontal"></i>
                  </span>
                  <input type="number" class="form-control" name="ancho" value="<?php echo ($product['ancho']);?>" placeholder="Longituda Ancho">
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class=" glyphicon glyphicon-resize-full"></i>
                  </span>
                  <input type="number" class="form-control" name="profundo" value="<?php echo $product['profundo']; ?>" placeholder="Longitud Profunda">
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-info-sign"></i>
                  </span>
                  <select class="form-control" name="unidad_longitud">
                    <option value="">Unidad de medida</option>
                    <option <?php echo $product['unidad_longitud'] ==  'Metros' ? 'selected' : '' ?> value="Metros">m</option>
                    <option <?php echo $product['unidad_longitud'] ==  'Centimetros' ? 'selected' : '' ?> value="Centimetros">cm</option>
                    <option <?php echo $product['unidad_longitud'] ==  'Milimetros' ? 'selected' : '' ?> value="Milimetros">mm</option>
                    <option <?php echo $product['unidad_longitud'] ==  'Pie' ? 'selected' : '' ?> value="Pie">pie</option>
                    <option <?php echo $product['unidad_longitud'] ==  'Pulgada' ? 'selected' : '' ?> value="Pulgada">pulgada</option>
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
                <option <?php echo $product['tipo_producto'] == 'natural_producto' ? 'selected' : '' ?> value="natural_producto">Naturaleza del Producto</option>
                <option <?php echo $product['tipo_producto'] == 'materia_prima' ? 'selected' : '' ?> value="materia_prima">Materia Prima</option>
                <option <?php echo $product['tipo_producto'] == 'producto' ? 'selected' : ''  ?> value="producto">Producto</option>
              </select>
            </div>

          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <textarea type="text" class="form-control" name="nota" placeholder="Nota Adicional"><?php echo $product['nota'] ?></textarea>
            </div>
          </div> <button type="submit" name="product" class="btn btn-danger">Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>