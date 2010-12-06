<?php

function validate_hash($hash,$user)
{
  global $files_list;
  if(!isset($files_list[$hash]))
  {
    header("Location: /u/{$user}");
  }
}

function directory_permission($directory,$mode)
{
  $fileinfo = new SplFileInfo($directory);
  if (!$fileinfo->isWritable()) {
    chmod($directory,$mode);
  }
}


function byte_format($num)
{
	if ($num >= 1000000000000) 
	{
		$num = round($num / 1099511627776, 1);
		$unit = "Tb";
	}
	elseif ($num >= 1000000000) 
	{
		$num = round($num / 1073741824, 1);
		$unit = "Gb";
	}
	elseif ($num >= 1000000) 
	{
		$num = round($num / 1048576, 1);
		$unit = "Mb";
	}
	elseif ($num >= 1000) 
	{
		$num = round($num / 1024, 1);
		$unit = "Kb";
	}
	else
	{
		$unit = "bytes";
		return number_format($num).' '.$unit;
	}

	return number_format($num, 1).' '.$unit;
}	