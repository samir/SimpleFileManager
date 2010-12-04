<?php

echo "<table>";
echo "<tr><td>Arquivo</td><td>Data/hora</td><td colspan='2'>Ação</td></tr>";
foreach($files_list as $hash=>$item )
{
  if(!in_array($item['filename'],array('.','..')))
  {
    echo "<tr><td>{$item['filename']}</td><td>{$item['mtime']}</td><td><a href='{$item['get_path']}'>[Baixar]</a></td><td><a href='{$item['del_path']}'>[Excluir]</a></td></tr>";
  }
}
echo "</table>";
?>