<?php

echo "  <table>".PHP_EOL;
echo "
    <tr>
      <th width='560'>Arquivo</th>
      <th width='100'>Tamanho</th>
      <th width='200'>Data/hora</th>
      <th width='40'>&nbsp;</th>
    </tr>".PHP_EOL;
$k = 0;
if(count($files_list) > 2)
{
  foreach($files_list as $hash=>$item )
  {
    if(!in_array($item['filename'],array('.','..')))
    {
      $k++;
      $class = ($k % 2 == 0) ? 'odd' : 'even';
      $del_link = (can_delete()) ? "<a href='{$item['del_path']}' class='lnk lnk_delete'>[Excluir]</a>" : "";
      echo "
        <tr class='{$class}'>
          <td>{$item['filename']}</td>
          <td>{$item['size']}</td>
          <td>{$item['mtime']}</td>
          <td><a href='{$item['get_path']}' class='lnk lnk_download'>[Baixar]</a>
              {$del_link}</td>
        </tr>".PHP_EOL;
    }
  }
}
else
{
      echo "
        <tr>
          <td colspan='4'>Nenhum arquivo encontrado</td>
        </tr>".PHP_EOL;
}
echo "
  </table>".PHP_EOL;
  
?>
<p><strong><?= $total['qtd']?></strong> arquivos totalizando <strong><?= byte_format($total['size'])?></strong></p>