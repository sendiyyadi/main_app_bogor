<?php
function get_user_pro_kd()
{
    $CI =& get_instance();
    $kode=($CI->session->userdata('user_area')? $CI->session->userdata('user_area') : '0000000000');
    return substr ($kode, 0, 2);
}
function get_user_kab_kd()
{
    $CI =& get_instance();
    $kode=($CI->session->userdata('user_area')? $CI->session->userdata('user_area') : '0000000000');
    return substr ($kode, 2, 2);
}

function get_user_kec_kd()
{
    $CI =& get_instance();
    $kode=($CI->session->userdata('user_area')? $CI->session->userdata('user_area') : '0000000000');
    return substr ($kode, 4, 3);
}

function get_user_kel_kd()
{
    $CI =& get_instance();
    $kode=($CI->session->userdata('user_area')? $CI->session->userdata('user_area') : '0000000000');
    return substr ($kode, 7, 3);
}


function is_user_kab()
{
    return (get_user_kec_kd()=='000');
}

function is_user_kec()
{
    return (get_user_kel_kd()=='000');
}

function is_user_kel()
{
    return (get_user_kel_kd()!='000');
}
/*
class nop_kode{
  public kd_propinsi='';
  var kd_dati2='';
  var kd_kecamatan='0';
  var kd_kelurahan='0';
  var kd_blok='0';
  var no_urut='0';
  var kd_jns_op='0';
  var panjang=0;

/*	function __construct()
	{
		parent::__construct();
  }

  function parsing($nop=''){
    $nop=replace($nop,'.','');
    $nop=replace($nop,'-','');
    $panjang=strlen($nop);
    $this->kd_propinsi=substring($nop,0,2);
    $this->kd_kecamatan=substring($nop,2,2);
    $this->kd_dati2=substring($nop,4,2);
    $this->kd_kecamatan=substring($nop,6,3);
    $this->kd_kelurahan=substring($nop,9,3);
    $this->kd_blok=substring($nop,11,3);
    $this->no_urut=substring($nop,14,4);
    $this->kd_jns_op=substring($nop,18,1);
  }

  function merge(){
    $nop=replace($nop,'.','');
    $nop=replace($nop,'-','');
    $panjang=strlen($nop);
    $this->kd_propinsi=substring($nop,0,2);
    $this->kd_kecamatan=substring($nop,2,2);
    $this->kd_dati2=substring($nop,4,2);
    $this->kd_kecamatan=substring($nop,6,3);
    $this->kd_kelurahan=substring($nop,9,3);
    $this->kd_blok=substring($nop,11,3);
    $this->no_urut=substring($nop,14,4);
    $this->kd_jns_op=substring($nop,18,1);
  }
  
}*/