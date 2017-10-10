<?php

echo get2Dec('45643.877676');


function get2Dec($string){
 $vals = explode('.', $string);
 $vals = $vals[0]. "." .substr($vals[1], 0, 2);
 return (float) $vals;
}
?>

use this tbody for the deptors

<?php  $datatable = get_all('customers');  ?>
                    <?php foreach ($datatable  as $row ): ?>
                      <tr>
                        <td><?= $row['id']?></td>
                        <td><?=$row['customer_name']?></td>
                        <td><?=$row['customer_phone']?></td>
                        <td> <?=Dformat($row['date_created'])?></td>
                        <td><?=$row['address']?></td>
                        <td ><span class=" btn btn-sm bg-green glyphicon glyphicon-pencil edit" id = "test" customer_data = <?= "'". json_encode($row) ."'" ?>  ></span></td>
                      </tr>

                    <?php endforeach ?>