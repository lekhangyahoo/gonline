<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup
{
    public $kVA;
    public $data;
    public $phase                   = 3;
    public $gen_number              = 1;
    public $gia_bon_dung            = 0;
    public $gia_ong_dan_dau         = 0;
    public $gia_tu_bom              = 0;
    public $gia_ong_khoi            = 0;    // bao gom lap
    public $gia_ong_nhung_non_che   = 0;    // gia tinh tren so luong cặp
    public $gia_cap_dong_luc        = 0;    // bao gom cong lap
    public $gia_cap_te              = 0;    // = $gia_cap dong_luc * 2 / 3
    public $gia_cap_dieu_khien      = 0;    // cable table, ampe = 99999
    public $gia_bao_ve_cap          = 0;
    public $gia_nhien_lieu_chay_nt  = 0;
    public $gia_vat_tu_phu          = 0;    // gia vat tu phu cho lap dat

    public $gia_kd_cl               = 0;
    public $gia_kd_tt3              = 0;
    public $gia_thu_tai_gia         = 0;
    public $gia_kiem_dinh           = 0;

    public $gia_lap_may             = 0;
    public $gia_thao_ra_vo          = 0;
    public $gia_lap_dat_ats         = 0;
    public $gia_lap_tu_hoa          = 0;
    public $gia_hd_sd_nt            = 0;
    public $gia_day_vao_vi_tri_dg   = 0;
    public $gia_day_vao_vi_tri_pt   = 0;
    public $gia_nhan_cong           = 0;

    public $distance                = 0;
    public $error_distance          = 0;
    public $gia_vc_duong_ngan       = 0;
    public $gia_vc_duong_dai        = 0;
    public $gia_vc_thu_cong         = 0;

    public $gia_ats                 = 0;

    public $gia_thoat_nhiet         = 0;
    public $gia_lam_gio             = 0;

    public function get_all_value(){
        $value = array(
            'gia_bon_dung'          => $this->gia_bon_dung,
            'gia_ong_dan_dau'       => $this->gia_ong_dan_dau,
            'gia_tu_bom'            => $this->gia_tu_bom,
            'gia_ong_khoi'          => $this->gia_ong_khoi * $this->gen_number,
            'gia_ong_nhung_non_che' => $this->gia_ong_nhung_non_che * $this->gen_number,
            'gia_cap_dong_luc'      => $this->gia_cap_dong_luc * $this->gen_number,
            'gia_cap_te'            => $this->gia_cap_te * $this->gen_number,
            'gia_cap_dieu_khien'    => $this->gia_cap_dieu_khien * $this->gen_number,
            'gia_bao_ve_cap'        => $this->gia_bao_ve_cap,
            'gia_nhien_lieu_chay_nt'=> $this->gia_nhien_lieu_chay_nt * $this->gen_number,
            'gia_vat_tu_phu'        => $this->gia_vat_tu_phu * $this->gen_number,
            'gia_kiem_dinh'         => $this->gia_kiem_dinh,
            'gia_nhan_cong'         => $this->gia_nhan_cong * $this->gen_number,
            'gia_vc_duong_ngan'     => $this->gia_vc_duong_ngan,
            'gia_vc_duong_dai'      => $this->gia_vc_duong_dai,
            'gia_vc_thu_cong'       => $this->gia_vc_thu_cong,
            'gia_ats'               => $this->gia_ats,
            'gia_thoat_nhiet'       => $this->gia_thoat_nhiet,
            'gia_lam_gio'           => $this->gia_lam_gio
        );

        $total_price = 0;
        foreach($value as $price){
            $total_price = $total_price + $price;
        }
        $parameters = array(
            'kVA'        => $this->kVA,
            'phase'      => $this->phase,
            'gen_number' => $this->gen_number,
            'total_money'=> $total_price,
            'total_price'=> format_currency($total_price),

            'gia_bon_dung_price'          => format_currency($this->gia_bon_dung),
            'gia_ong_dan_dau_price'       => format_currency($this->gia_ong_dan_dau),
            'gia_tu_bom_price'            => format_currency($this->gia_tu_bom),
            'gia_ong_khoi_price'          => format_currency($this->gia_ong_khoi),
            'gia_ong_nhung_non_che_price' => format_currency($this->gia_ong_nhung_non_che),
            'gia_cap_dong_luc_price'      => format_currency($this->gia_cap_dong_luc),
            'gia_cap_te_price'            => format_currency($this->gia_cap_te),
            'gia_cap_dieu_khien_price'    => format_currency($this->gia_cap_dieu_khien),
            'gia_bao_ve_cap_price'        => format_currency($this->gia_bao_ve_cap),
            'gia_nhien_lieu_chay_nt_price'=> format_currency($this->gia_nhien_lieu_chay_nt),
            'gia_vat_tu_phu_price'        => format_currency($this->gia_vat_tu_phu),
            'gia_kd_cl_price'             => format_currency($this->gia_kd_cl),
            'gia_kd_tt3_price'            => format_currency($this->gia_kd_tt3),
            'gia_thu_tai_gia_price'       => format_currency($this->gia_thu_tai_gia),
            'gia_kiem_dinh_price'         => format_currency($this->gia_kiem_dinh),
            'gia_nhan_cong_price'         => format_currency($this->gia_nhan_cong),
            'gia_thao_ra_vo'              => format_currency($this->gia_thao_ra_vo),
            'gia_lap_may_price'           => format_currency($this->gia_lap_may),
            'gia_lap_dat_ats_price'       => format_currency($this->gia_lap_dat_ats),
            'gia_lap_tu_hoa_price'        => format_currency($this->gia_lap_tu_hoa),
            'gia_hd_sd_nt_price'          => format_currency($this->gia_hd_sd_nt),
            'gia_day_vao_vi_tri_dg_price' => format_currency($this->gia_day_vao_vi_tri_dg),
            'gia_day_vao_vi_tri_pt_price' => format_currency($this->gia_day_vao_vi_tri_pt),

            'distance'                    => $this->distance,
            'error_distance'              => $this->error_distance,
            'gia_vc_duong_ngan_price'     => format_currency($this->gia_vc_duong_ngan),
            'gia_vc_duong_dai_price'      => format_currency($this->gia_vc_duong_dai),
            'gia_vc_thu_cong_price'       => format_currency($this->gia_vc_thu_cong),
            'gia_ats'                     => format_currency($this->gia_ats),
            'gia_thoat_nhiet'             => format_currency($this->gia_thoat_nhiet),
            'gia_lam_gio'                 => format_currency($this->gia_lam_gio)
        );
        //pr(array_merge($parameters, $value));exit;
        return json_encode(array_merge($parameters, $value));
    }

    public function set($kVA, $phase, $gen_number)
    {
        \CI::load()->model(['Materials']);
        $this->kVA          = $kVA;
        $this->phase        = $phase;
        $this->gen_number   = $gen_number;

        $this->data         = \CI::Materials()->getMaterials($kVA, $gen_number);

        //echo '<pre>';print_r($this->data);exit;
    }

    /*
        dtb = dung tich bon (lit)
        dk = duong kinh (m)
        day = do day cua thep (mm)
    */
    public function bon_dung($dtb = 5000, $dk = 2, $day = 3){
        if($dtb > 0 && $dk > 0 && $day > 0) {
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

    }

    /*

    */
    public function ong_dan_dau($loai_ong_dan_dau = 'ODD21', $loai_van_dau = 'VDD21', $length, $so_luong_van){
        if($length > 0) {
            // gia ong
            $gia_ong = $this->data['basic'][$loai_ong_dan_dau]->value * $length * 1.1;

            // gia van
            $tinh_so_van = round($length/4, 0, PHP_ROUND_HALF_DOWN);
            if($tinh_so_van == 0)
                 $so_luong_van = 1;
            else if($tinh_so_van > 3)
                 $so_luong_van = 3;
            else $so_luong_van = $tinh_so_van;
            $gia_van = $this->data['basic'][$loai_van_dau]->value * $so_luong_van;

            // gia nhan cong
            if ($length < $this->data['basic']['GIA_ONG_DAU']->condition)
                $gia_nhan_cong = $this->data['basic']['GIA_ONG_DAU']->value;
            else $gia_nhan_cong = $this->data['basic']['GIA_ONG_DAU']->value + $length * $this->data['basic']['GIA_ONG_DAU']->condition_value;

            $tong_gia = $gia_ong + $gia_van + $gia_nhan_cong;
            $gia_ong_dan_dau = $tong_gia / $this->data['constants']['PROFIT_40']->value;
            $this->gia_ong_dan_dau = $gia_ong_dan_dau;
        }
    }

    public function tu_bom($quantity){
        $tong_gia = $quantity * ($this->data['basic']['TU_BOM']->value + $this->data['basic']['TU_BOM_PK']->value + $this->data['basic']['BOM_DAU_PK']->value);
        $gia_tu_bom = $tong_gia / $this->data['constants']['PROFIT_40']->value;
        $this->gia_tu_bom = $gia_tu_bom;
    }

    public function ong_khoi($phi, $length, $do_day_ong_khoi = 2,  $rockwool = true, $quantity_ong_nhung = 1, $quantity_funnel = 1){
        $PI = $this->data['constants']['PI']->value;
        $do_day_ong_khoi = $do_day_ong_khoi*0.001;
        // gia thep (d/m)
        // do day cua thep 2mm
        $don_gia_thep = $this->data['basic']['THEP_ONG']->value;
        if($this->data['funnel'][$phi]->group) {  // truong hop gia innox
            $don_gia_thep = $this->data['basic']['INOX_ONG_304']->value;
        }
        $gia_thep = (  ( ($phi / 1000 * $PI) * $do_day_ong_khoi ) * 7856  ) * $don_gia_thep;
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
        $gia_nhan_cong = ( ($phi / 1000 * $PI * $do_day_ong_khoi * 2.5 * 7856 ) + ( ( (($phi + 100) / 1000) * $PI ) / 4 * 0.006 * 7856)) * 2000;

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

        $this->gia_ong_khoi = $gia_ong_khoi * $quantity_funnel;


        /* tinh gia ong nhung non che */
        $ong_nhung  = ( $this->data['funnel'][$phi]->value_onnh + $this->data['funnel'][$phi]->value_mabi * 2 ) / $this->data['constants']['PROFIT_20']->value;
        $non_che    = ( $this->data['funnel'][$phi]->value_noch ) * $this->data['constants']['PROFIT_20']->value;
        // gia ong nhung no che : 1 cap
        $gia_ong_nhung_non_che          = ( $ong_nhung * 2 + $non_che ) * $quantity_ong_nhung;
        $this->gia_ong_nhung_non_che    = $gia_ong_nhung_non_che;
    }

    public function cap_dong_luc($length = 1){
        // 3 pha gom 3 day nong + 1 day trung hoa ( day trung hoa ampe = 1/2 )
        $ampe = $this->kVA;
        if($this->phase = 3){
            $quantity = 3;
            $ampe = $this->kVA * 1.52 * 1.2; // ~ 1.8
        }
        else $ampe = $this->kVA * 4.54 * 1.2;//

        foreach($this->data['cable'] as $key=>$value){
            if($key >= $ampe) {
                $ampe = $key;
                break;
            }
        }
        // xac dinh ampe day trung hoa
        foreach($this->data['cable'] as $key=>$value){
            if($key >= ($ampe/2) ) {
                $ampe_day_trung_hoa = $key;
                break;
            }
        }

        $gia        = ($this->data['cable'][$ampe]->value * 0.9) / 0.8; // d/m
        $tong_gia   = $gia * $length * $quantity + ($this->data['cable'][$ampe_day_trung_hoa]->value * 0.9) / 0.8 * $length; // day day nong + day trung hoa
        $this->gia_cap_dong_luc = $tong_gia;
    }

    public function cap_te(){
        $this->gia_cap_te = $this->gia_cap_dong_luc * 2 / 3;
    }

    public function cap_dieu_khien($length = 1){
        $gia = ( ($this->data['cable'][99999]->value * 0.9) / 0.8 ) * $length;
        $this->gia_cap_dieu_khien = $gia;
    }

    public function bao_ve_cap($length = 1){
        $gia = ($this->data['basic']['ONG_PVC']->value * 0.9) / 0.8 * $length;
        $this->gia_bao_ve_cap = $gia;
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

    public function vc_duong_dai($km, $weight){
        $this->gia_vc_duong_dai = $km * $this->data['basic']['GIA_VC_DUONG_DAI']->value;
    }

    public function kiem_dinh($kd_chat_luong = 1, $kd_tt3 = 1, $thu_tai_gia = 1){
        if($kd_chat_luong > 0)
            $gia_kd_chat_luong  = /*$kd_chat_luong * */$this->data['basic']['KIEM_DINH_CL']->value + ($kd_chat_luong - 1) * $this->data['basic']['KIEM_DINH_CL']->condition_value;
        else $gia_kd_chat_luong = 0;
        $this->gia_kd_cl        = $gia_kd_chat_luong;
        $this->gia_kd_tt3       = $kd_tt3 * $this->data['basic']['KIEM_DINH_CS']->value;
        $this->gia_thu_tai_gia  = $thu_tai_gia * $this->data['basic']['KIEM_DINH_THU_TAI']->value;
        $this->gia_kiem_dinh    = $this->gia_kd_cl + $this->gia_kd_tt3 + $this->gia_thu_tai_gia;
    }

    public function nhan_cong($thao_ra_vo = 0, $day_vao_vi_tri_dg = 0, $day_vao_vi_tri_pt = 0, $lap_may = 0, $lap_dat_ats = 0, $lap_tu_hoa = 0, $gia_hd_sd_nt = 0){
        if($thao_ra_vo > 0){
            if($this->kVA < 65)
                    $gia_thao_ra_vo = 1000000;
            else if($this->kVA < 200)
                    $gia_thao_ra_vo = 1500000;
            else if($this->kVA < 500)
                    $gia_thao_ra_vo = 2200000;
            else if($this->kVA < 900)
                    $gia_thao_ra_vo = 3000000;
            else    $gia_thao_ra_vo = 5000000;

            $gia_thao_ra_vo = $gia_thao_ra_vo * $thao_ra_vo;
        }else $gia_thao_ra_vo = 0;
        $this->gia_thao_ra_vo = $gia_thao_ra_vo;

        $gia_day_vao_vi_tri_dg = $day_vao_vi_tri_dg * $this->data['basic']['NC_DAY_VAO_VT_DG']->value;
        if($day_vao_vi_tri_pt > 0){
            if($this->kVA < 40)
                $gia_day_vao_vi_tri_pt = 1200000;
            else if($this->kVA < 250)
                $gia_day_vao_vi_tri_pt = 2500000;
            else if($this->kVA < 500)
                $gia_day_vao_vi_tri_pt = 4000000;
            else if($this->kVA < 850)
                $gia_day_vao_vi_tri_pt = 6000000;
            else
                $gia_day_vao_vi_tri_pt = 8000000;

            $gia_day_vao_vi_tri_pt = $gia_day_vao_vi_tri_pt * $day_vao_vi_tri_pt;
        }else $gia_day_vao_vi_tri_pt = 0;

        $this->gia_day_vao_vi_tri_dg = $gia_day_vao_vi_tri_dg;
        $this->gia_day_vao_vi_tri_pt = $gia_day_vao_vi_tri_pt;

        $gia_lap_may        = $this->gia_lap_may        = $lap_may * $this->data['basic']['NC_LD_MAY_PHAT']->value;
        $gia_lap_dat_ats    = $this->gia_lap_dat_ats    = $lap_dat_ats * $this->data['basic']['NC_LD_TU_ATS']->value;
        $gia_lap_tu_hoa     = $this->gia_lap_tu_hoa     = $lap_tu_hoa * $this->data['basic']['NC_LD_TU_HOA']->value;
        $gia_hd_sd_nt       = $this->gia_hd_sd_nt       = $gia_hd_sd_nt * $this->data['basic']['NC_HD_NT']->value;
        $this->gia_nhan_cong = $gia_thao_ra_vo + $gia_day_vao_vi_tri_dg + $gia_day_vao_vi_tri_pt + $gia_lap_may + $gia_lap_dat_ats + $gia_lap_tu_hoa + $gia_hd_sd_nt;
    }

    public function khoang_cach($province, $district, $ward, $address){
        $get_province = \CI::Locations()->get_zone($province);
        $province = $get_province->name;
        $address_tmp_1 = trim(str_replace(" ","+",$address."+".$ward."+".$district."+".$province),"+");
        //echo $address_tmp_1;exit;
        //$address_tmp_2 = trim(str_replace(" ","+",$ward."+".$district."+".$province),"+");
        //$address_tmp_3 = trim(str_replace(" ","+",$district."+".$province),"+");
        //$address_tmp_4 = trim(str_replace(" ","+",$province),"+");
        //$details = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=10.880659,106.750029&destinations=234+le+van+luong+nha+be+ho+chi+minh+vietnam&key=AIzaSyDIafD0HzwUeKBRqqufYxe080MCJniWERs';
        $details = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.str_replace(' ', '', $this->data['basic']['LAT_LON_GOOGLE_MAP']->unit).'&destinations='.$address_tmp_1.'+vietnam&key=AIzaSyDIafD0HzwUeKBRqqufYxe080MCJniWERs';
        $json = file_get_contents($details);
        $details = json_decode($json, TRUE);
        if($details['rows'][0]['elements'][0]['status']=='OK') {
            $km = $details['rows'][0]['elements'][0]['distance']['text'];
            $km = str_replace(',', '', $km);
            $this->distance = ceil($km);
            if ($this->distance < 50) {
                $this->vc_duong_ngan($this->distance);
            } else {
                $this->vc_duong_dai($this->distance);
            }
        }else{
            $this->error_distance = true;
        }
        //echo $this->distance;echo "<pre>"; print_r($details); echo "</pre>";
        //echo $this->distance.':';echo $this->gia_vc_duong_dai;exit;
    }

    public  function vc_thu_cong($times = 1){
        $this->gia_vc_thu_cong = $times * $this->data['basic']['GIA_VC_THU_CONG']->value;
    }

    public function thoat_nhiet(){
        $width          = $this->data['febrifuge']->width;
        $height         = $this->data['febrifuge']->height;
        $value_vtp      = $this->data['febrifuge']->value_vtp;
        $gia_thep       = ((((($width+$height)*2+100))*1100)/1000000)*0.0008*7856*$this->data['basic']['THEP_MA_KEM']->value*1.1;
        $nep            = ((0.08*1.1*0.002*7856)*4*$this->data['basic']['NEP_RANG_CUA']->value)+10000;
        $gia_do_hop     = ((($width+100)/1000)*2)*2.1*$this->data['basic']['GIA_DO']->value;
        $ty_ren         = ($height+400)/1000*$this->data['basic']['TY_REN_10']->value/1.5;
        $ke_goc         = $this->data['basic']['KE_GOC']->value*4/1.5;
        $gioang_cao_su  = (($width+$height)*2)/1000*79000/5;
        $cong_san_xuat  = ((((($width+$height)*2+100))*1100)/1000000)*0.0008*7856*3000+150000;

        $gia_thoat_nhiet= $gia_thep + $nep + $gia_do_hop + $ty_ren + $ke_goc + $gioang_cao_su + $cong_san_xuat + $value_vtp;

        $kl_khung       = (((($width+$height)*1.2)*2*200)/1000000)*0.002*7856;
        $kl_lam         = (((140*$height*1.2)/1000000)*0.0008*7856)*($width*1.2/100);
        $tong_kl        = $kl_khung + $kl_lam;
        $gia_thep       = $tong_kl*$this->data['basic']['THEP_MA_KEM']->value;
        $gia_nhan_cong  = $tong_kl*$this->data['basic']['CONG_SX_LAM_GIO']->value+150000;
        $gia_lam_gio    = $gia_thep + $gia_nhan_cong + $value_vtp;

        $this->gia_thoat_nhiet  = $gia_thoat_nhiet= $gia_thoat_nhiet/0.8;
        $this->gia_lam_gio      = $gia_lam_gio    = $gia_lam_gio/0.8;
    }
    public function tu_ats(){
        $ats = \CI::Products()->getAts(($this->kVA/1.72)/0.83);
        //echo lqr();pr($ats);exit;
        $this->gia_ats = $ats->price_1;
        //echo $this->gia_ats;exit;
    }
}