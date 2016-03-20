<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup
{
    protected $kVA;
    protected $data;
    public $gia_bon_dung            = 0;
    public $gia_ong_dan_dau         = 0;
    public $gia_tu_bom              = 0;
    public $gia_ong_khoi            = 0;    // bao gom lap
    public $gia_ong_nhung_non_che   = 0;    // gia tinh tren so luong cặp
    public $gia_dong_luc            = 0;    // bao gom cong lap
    public $gia_cap_te              = 0;    // = $gia_dong_luc * 2 / 3
    public $gia_cap_dieu_khien      = 0;    // cable table, ampe = 99999
    public $gia_cap_bao_ve          = 0;
    public $gia_nhien_lieu_chay_nt  = 0;
    public $gia_vat_tu_phu          = 0;    // gia vat tu phu cho lap dat
    public $gia_vc_duong_ngan       = 0;

    public function set($kVA)
    {
        \CI::load()->model(['Materials']);
        $this->kVA = $kVA;

        $this->data = \CI::Materials()->getMaterials();

        //echo '<pre>';print_r($this->data);exit;
    }

    /*
        dtb = dung tich bon (lit)
        dk = duong kinh (m)
        day = do day cua thep (mm)
    */
    public function bon_dung($dtb = 5000, $dk = 2, $day = 3){
        $PI = $this->data['constants']['PI']->value;
        $TT_THEP = $this->data['constants']['TT_THEP']->value;
        $GIA_THEP = $this->data['basic']['GIA_THEP']->value;
        // gia thep
        $gia_thep = 2 * $PI * ($dtb / 1000 / $PI / $dk * 2 + $dk * $dk / 4) * $day / 1000 * $TT_THEP * 1.2 * $GIA_THEP;
        // gia gia cong
        $gia_gia_cong = $gia_thep / $this->data['basic']['GIA_THEP']->value * $this->data['basic']['GIA_GC']->value;
        // vat tu khac

        $tong_gia = $gia_thep + $gia_gia_cong + $this->data['basic']['BON_DAU_THANG_VTK']->value;
        $gia_bon_dung = $tong_gia / $this->data['constants']['PROFIT_40']->value;
        $this->gia_bon_dung = $gia_bon_dung;
    }

    /*

    */
    public function ong_dan_dau($loai_ong_dan_dau = 'ODD21', $loai_van_dau = 'VDD21', $length, $so_luong_van){
        // gia ong
        $gia_ong = $this->data['basic'][$loai_ong_dan_dau]->value * $length * 1.1;
        // gia van
        $gia_van = $this->data['basic'][$loai_van_dau]->value * $so_luong_van;
        // gia nhan cong
        if($length < $this->data['basic']['GIA_ONG_DAU']->condition)
            $gia_nhan_cong  = $this->data['basic']['GIA_ONG_DAU']->value;
        else $gia_nhan_cong = $this->data['basic']['GIA_ONG_DAU']->value + $length * $this->data['basic']['GIA_ONG_DAU']->condition_value;

        $tong_gia        = $gia_ong + $gia_van + $gia_nhan_cong;
        $gia_ong_dan_dau = $tong_gia / $this->data['constants']['PROFIT_40']->value;
        $this->gia_ong_dan_dau = $gia_ong_dan_dau;
    }

    public function tu_bom($quantity){
        $tong_gia = $quantity * ($this->data['basic']['TU_BOM']->value + $this->data['basic']['TU_BOM_PK']->value + $this->data['basic']['BOM_DAU_PK']->value);
        $gia_tu_bom = $tong_gia / $this->data['constants']['PROFIT_40']->value;
        $this->gia_tu_bom = $gia_tu_bom;
    }

    public function ong_khoi($phi, $length, $rockwool = true, $quantity_ong_nhung = 1){
        $PI = $this->data['constants']['PI']->value;
        // gia thep (d/m)
        // do day cua thep 2mm
        $don_gia_thep = $this->data['basic']['THEP_ONG']->value;
        if($this->data['funnel'][$phi]->group) {  // truong hop gia innox
            $don_gia_thep = $this->data['basic']['INOX_ONG_304']->value;
        }
        $gia_thep = (  ( ($phi / 1000 * $PI) * 0.002 ) * 7856  ) * $don_gia_thep;

        // gia son (d/m)
        $gia_son        = ($phi / 1000 * $PI) * $this->data['basic']['GIA_SON']->value;

        // gia que han
        $gia_que_han    = ( (0.008 * 0.008 * 7856)+(0.008 * 0.008 * 7856 * ($phi / 1000) * $PI * 2) ) * $this->data['basic']['QUE_HAN']->value;

        // gia rockwool
        if($rockwool)
            $gia_rockwool   = ( $phi / 1000 * $PI ) * $this->data['basic']['ROCKWOOL_100kg_m3']->value * 1.1;
        else $gia_rockwool  = 0;

        $gia_ton_inox   = ( ( ($phi + 100) / 1000 * $PI ) + 0.1 ) * 0.0002 * 7856 * $this->data['basic']['TON_INOX']->value;

        $gia_do = ( ( ($phi + 100 ) / 1000) * 5.8 ) * $this->data['basic']['GIA_DO']->value + 12000;

        // gia nhan cong
        $gia_nhan_cong = ( ($phi / 1000 * $PI * 0.002 * 2.5 * 7856 ) + ( ( (($phi + 100) / 1000) * $PI ) / 4 * 0.006 * 7856)) * 2000;

        $tong_gia = $gia_thep * $length +
                    $this->data['funnel'][$phi]->value_mabi * 2 / 2.5 +
                    //$this->data['funnel'][$phi]->value_coha +
                    $gia_son * $length +
                    $gia_que_han * $length +
                    //$gia_ton_inox * $length +
                    $gia_do * $length +
                    $this->data['funnel'][$phi]->value_vtp +
                    $gia_nhan_cong * $length
        ;
        if($rockwool)
            $tong_gia = $tong_gia + $gia_rockwool * $length + $gia_ton_inox * $length;

        $gia_ong_khoi = $tong_gia / $this->data['constants']['PROFIT_20']->value;

        $this->gia_ong_khoi = $gia_ong_khoi;


        /* tinh gia ong nhung non che */
        $ong_nhung  = ( $this->data['funnel'][$phi]->value_onnh + $this->data['funnel'][$phi]->value_mabi * 2 ) / $this->data['constants']['PROFIT_20']->value;
        $non_che    = ( $this->data['funnel'][$phi]->value_noch ) * $this->data['constants']['PROFIT_20']->value;
        // gia ong nhung no che : 1 cap
        $gia_ong_nhung_non_che          = ( $ong_nhung * 2 + $non_che ) * $quantity_ong_nhung;
        $this->gia_ong_nhung_non_che    = $gia_ong_nhung_non_che;
    }

    public function cap_dong_luc($ampe, $length = 1, $quantity = 1){
        $gia = ($this->data['cable'][$ampe]->value*0.9)/0.8; // d/m
        $tong_gia = $gia * $length * $quantity;
        $this->gia_dong_luc = $tong_gia;
    }

    public function cap_te($ampe, $length = 1, $quantity = 1){
        $this->gia_cap_te = $this->gia_dong_luc * 2 / 3;
    }

    public function cap_dieu_khien($length = 1){
        $gia = ( ($this->data['cable'][99999]->value * 0.9) / 0.8 ) * $length;
        $this->gia_cap_dieu_khien = $gia;
    }

    public function cap_bao_ve($length = 1){
        $gia = ($this->data['basic']['ONG_PVC']->value * 0.9) / 0.8 * $length;
        $this->gia_cap_bao_ve = $gia;
    }

    public function nhien_lieu_chay_nt($lit = 1){
        $gia = ($this->data['basic']['GIA_DAU_DIESEL']->value * 0.9) / 0.8 * $lit;
        $this->gia_nhien_lieu_chay_nt = $gia;
    }

    public function vat_tu_phu($bo = 1){
        $this->gia_vat_tu_phu = $this->data['basic']['LAP_DAT_VTP']->value * $bo;
    }

    public function vc_duong_ngan($km)
    {
        $kVA = $this->kVA;
        $gia = 0;
        if ($kVA < 50){
            If ($km <= 5){
                $gia = 700;
            }
            else{
                if($km <= 25)
                    $gia = 700 + ($km - 5) * 30;
                else
                    $gia = 700 + 20 * 30 + ($km - 25) * 20;
            }
        }
        else {
            if ($kVA < 250) {
                if ($km <= 5)
                    $gia = 1000;
                else
                    if ($km <= 25)
                        $gia = 1000 + ($km - 5) * 30;
                    else
                        $gia = 1000 + 20 * 30 + ($km - 25) * 20;
            } else {
                if ($kVA < 500) {
                    if ($km <= 5)
                        $gia = 1300;
                    else
                        if ($km <= 25)
                            $gia = 1300 + ($km - 5) * 40;
                        else
                            $gia = 1300 + 20 * 40 + ($km - 25) * 30;
                } else {
                    if ($kVA <= 850) {
                        if ($km <= 5)
                            $gia = 1600;
                        else
                            if ($km <= 25)
                                $gia = 1600 + ($km - 5) * 70;
                            else
                                $gia = 1600 + 20 * 70 + ($km - 25) * 40;
                    } else {
                        if ($km <= 5)
                            $gia = 3000;
                        else
                            if ($km <= 25)
                                $gia = 3000 + ($km - 5) * 80;
                            else
                                $gia = 3000 + 20 * 80 + ($km - 25) * 50;
                    }
                }

            }
        }
        $this->gia_vc_duong_ngan = $gia * 1000;

    }

    public function vc_duong_dai($km){
        $this->gia_vc_duong_dai = $km * $this->data['basic']['VC_DUONG_DAI']->value;
    }
}
