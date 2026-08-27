<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");
$modul = "pbbm_new";

$route["{$modul}/about"] = "irul"; //sample aja; langsung nama controller di dalam module-nya

$route["{$modul}/dph_posting"]         = "dph"; 
$route["{$modul}/dph_posting/(:any)"]  = "dph/$1"; 