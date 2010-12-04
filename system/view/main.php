<?php

echo "  <table border='1'>".PHP_EOL;
echo "
    <tr>
      <td width='500'>Arquivo</td>
      <td width='200'>Data/hora</td>
      <td width='200' colspan='2'>Ação</td>
    </tr>".PHP_EOL;

$k = 0;

foreach($files_list as $hash=>$item )
{
  if(!in_array($item['filename'],array('.','..')))
  {
    $k++;
    $class = ($k % 2 == 0) ? 'odd' : 'even';
    echo "
      <tr class='{$class}'>
        <td>{$item['filename']}</td>
        <td>{$item['mtime']}</td>
        <td><a href='{$item['get_path']}'>[Baixar]</a></td>
        <td><a href='{$item['del_path']}'>[Excluir]</a></td>
      </tr>".PHP_EOL;
  }
}
echo "
  </table>".PHP_EOL;
?>