<?php
  $page_title = 'Lista de productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-primary">Agregar producto</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">Ref</th>                
                <th> Descripción </th>                
                <th class="text-center" style="width: 10%;"> Stock </th>
                <th class="text-center" style="width: 10%;"> Codigo </th>
                <th class="text-center" style="width: 10%;"> Precio de venta </th>
                <th class="text-center" style="width: 10%;"> Precio de compra </th>
                <th class="text-center" style="width: 10%;"> ¿Aplica IVA? </th>
                <th class="text-center" style="width: 10%;"> Almacen por defecto </th>
           <!-- <th class="text-center" style="width: 10%;"> Peso </th> -->
           <!--  <th class="text-center" style="width: 10%;"> Volumen </th> -->
           <!-- <th class="text-center" style="width: 10%;"> Alto </th>
           <th class="text-center" style="width: 10%;"> Ancho </th>
           <th class="text-center" style="width: 10%;"> Profundo </th> -->
           <!-- <th class="text-center" style="width: 10%;"> Unidad Longitud </th> -->
           <th class="text-center" style="width: 10%;"> Tipo Producto </th>
           <th class="text-center" style="width: 10%;"> Nota </th>
           <th class="text-center" style="width: 10%;"> Fecha Creación </th>
           <th class="text-center" style="width: 100px;"> Acciones </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>                
                <td> <?php echo remove_junk($product['name']); ?></td>               
                <td class="text-center"> <?php echo ($product['quantity']); ?></td>
                <td class="text-center"> <?php echo ($product['label']); ?></td>
                <td class="text-center"> <?php echo ($product['buy_price']); ?></td>
                <td class="text-center"> <?php echo ($product['sale_price']); ?></td>
                <td class="text-center"> <?php echo ($product['iva']); ?></td>
                <td class="text-center"> <?php echo ($product['almacen']); ?></td>
             <td class="text-center"> <?php echo (($product['tipo_producto'])); ?></td>
             <td class="text-center"> <?php echo (($product['nota'])) ?></td>
             <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center"> 
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
