<?php
  $page_title = 'Editar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saleing-price' );
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
       $p_buy   = remove_junk($db->escape($_POST['buying-price']));
       $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}',";
       $query  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}',media_id='{$media_id}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Producto ha sido actualizado. ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
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
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-8">
                    <select class="form-control" name="product-categorie">
                    <option value="">Selecciona una categoría</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  
                </div>
              </div>

              <div class="form-group">
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
                      <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($product['buy_price']);?>">
                      
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
                       <input type="number" class="form-control" name="saleing-price" value="<?php echo remove_junk($product['sale_price']);?>">

                       
                       
                    </div>
                   </div>
                  </div>
               </div>
              </div>

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
                <select class="form-control" name="IVA"> 
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
                <textarea type="text" class="form-control" name="nota" placeholder="Nota Adicional"></textarea>              
              </div>
            </div>              <button type="submit" name="product" class="btn btn-danger">Actualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
