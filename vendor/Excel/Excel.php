<?php
namespace app\shops\controller;
use app\base\BaseController;
use think\Session;
use think\Log;
use think\Db;
use app\shops\model\GoodsModel;
use app\shops\model\DingdanModel;

class Excel extends BaseController{
    //公共导出
    public function export($objPHPExcel,$filename='kelaReport'){
        ob_clean();
        $objPHPExcel -> getActiveSheet() -> setTitle($filename);
        $objPHPExcel -> setActiveSheetIndex(0);
        $file_name = $filename.".xlsx";
        header("Content-Type: application/force-download");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition:attachment;filename =$file_name");
        header('Cache-Control: max-age=0');
        header("Content-Transfer-Encoding:8bit");

        vendor('Excel.PHPExcel.IOFactory');
        require(PHPEXCEL_ROOT . 'PHPExcel/Shared/ZipArchive.php');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter -> save('php://output');
        exit ;
    }

    //导出留言信息
    //拍摄任务板版列表
    public function outSeoEarnst($list = array()){
        vendor('Excel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $i = 1;
        $objPHPExcel -> setActiveSheetIndex(0)
            -> setCellValue("A$i", "id")
            -> setCellValue("B$i", "任务名")
            -> setCellValue("C$i", "开始时间")
            -> setCellValue("D$i", "利润")
            -> setCellValue("E$i", "定金")
        ;
        foreach ($list as $val) {
            $i++;
            $objPHPExcel -> setActiveSheetIndex(0)
                -> setCellValue("A$i", $val["ct_id"])
                -> setCellValue("B$i", $val["ct_name"])
                -> setCellValue("C$i", $val["ct_create_time"])
                -> setCellValue("D$i", $val["ct_price"])
                -> setCellValue("E$i", $val["ct_deposit"]);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'E')->setAutoSize(true);
        }
        $filename = "拍摄任务列表";
        $this->export($objPHPExcel,$filename);
    }

    //Excel打印
    //导出商品列表
    //商品表全部打印
    public function goods_all()
    {
        $mk_id=Session::get('mk_id');
        $goods=new GoodsModel();
        $list = $goods->get_goods($mk_id);
        $this->goods_dayin($list);
    }

    //商品表部分打印
    public function goods_sel()
    {
        $ids = input('get.id');
        log::info('ids:'.$ids);
        $mk_id=Session::get('mk_id');
        $goods=new GoodsModel();
        $list = $goods->dayin_goods($mk_id,$ids);
        $this->goods_dayin($list);
    }


    public function goods_dayin($list)
    {
        vendor('Excel.PHPExcel');
        $objPHPExcel = new \PHPExcel();

        $i = 1;
        $objPHPExcel -> setActiveSheetIndex(0)
            -> setCellValue("A$i", "id")
            -> setCellValue("B$i", "商品名")
            -> setCellValue("C$i", "淘宝店铺名")
            -> setCellValue("D$i", "图片")
            -> setCellValue("E$i", "价格")
            -> setCellValue("F$i", "商品编码")
            -> setCellValue("G$i", "是否在售")
            -> setCellValue("H$i", "商品类型")
        ;
        foreach ($list as $val) {
            $i++;
            $objPHPExcel -> setActiveSheetIndex(0)
                -> setCellValue("A$i", $val["id"])
                -> setCellValue("B$i", $val["name"])
                -> setCellValue("C$i", $val["tb_name"])
                -> setCellValue("D$i", $val["thumb"])
                -> setCellValue("E$i", $val["price"])
                -> setCellValue("F$i", $val["code"])
                -> setCellValue("G$i", $val["is_delete"])
                -> setCellValue("H$i", $val["cate"]);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'H')->setAutoSize(true);
        }
        $filename = "商品列表";
        $this->export($objPHPExcel,$filename);
    }

    //订单列表全部打印
    public function dingdan_all()
    {
        $goods=new DingdanModel();
        $list = $goods->ding();
        $this->dayin_dingdan($list);
    }

    //订单列表选中打印
    public function dingdan_sel()
    {
        $ids = input('get.id');
        $goods=new DingdanModel();
        $list = $goods->ding_bufen($ids);
        $this->dayin_dingdan($list);
    }

    public function dayin_dingdan($list)
    {
        vendor('Excel.PHPExcel');
        $objPHPExcel = new \PHPExcel();

        $i = 1;
        $objPHPExcel -> setActiveSheetIndex(0)
            -> setCellValue("A$i", "订单编号")
            -> setCellValue("B$i", "购买用户编号")
            -> setCellValue("C$i", "门店编号")
            -> setCellValue("D$i", "交易状态")
            -> setCellValue("E$i", "支付方式")
            -> setCellValue("F$i", "付款金额")
            -> setCellValue("G$i", "创建时间")
            -> setCellValue("H$i", "退款金额")
            -> setCellValue("I$i", "退款时间")
            -> setCellValue("J$i", "备注")
            -> setCellValue("K$i", "结算时间")
        ;
        foreach ($list as $val) {
            $i++;
            $objPHPExcel -> setActiveSheetIndex(0)
                -> setCellValue("A$i", $val["id"])
                -> setCellValue("B$i", $val["userid"])
                -> setCellValue("C$i", $val["marketid"])
                -> setCellValue("D$i", $val["status"])
                -> setCellValue("E$i", $val["method"])
                -> setCellValue("F$i", $val["pay_real"])
                -> setCellValue("G$i", $val["addtime"])
                -> setCellValue("H$i", $val["pay_refund"])
                -> setCellValue("I$i", $val["time_refund"])
                -> setCellValue("J$i", $val["note_refund"])
                -> setCellValue("K$i", $val["endtime"]);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'G')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'H')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'I')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'J')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension( 'K')->setAutoSize(true);
        }
        $filename = "订单时间";
        $this->export($objPHPExcel,$filename);
    }

    //订单文件导入
    public function dingdan_upload()
    {
        if (request()->file('upfile')) {
            $file = request()->file('upfile');
            $info = $file->validate(['size'=>3145728,'ext'=>'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info) {
                // 上传成功 获取上传文件信息
                $info->getExtension();
                $info->getSaveName();
                $info->getFilename();

            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }

            $extension = $info->getExtension();
            $file_name =  ROOT_PATH . 'public' . DS . 'uploads'  . DS . $info->getSaveName();

            vendor('Excel.PHPExcel');

            if( $extension =='xlsx' || $extension == 'xls') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            }
            else {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }

            //$objReader = \PHPExcel_IOFactory::createReader('Excel5');//创建读取实例

            $objPHPExcel = $objReader->load($file_name,$encode='utf-8');//加载文件
            $sheet = $objPHPExcel->getSheet(0);//取得sheet(0)表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            //\PHPExcel_Cell::columnIndexFromString(); //字母列转换为数字列 如:AA变为27
            for($i=2;$i<=$highestRow;$i++)
            {
                //$data['id']=$objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
                $data['userid'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
                $data['marketid'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
                $data['status']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                $data['method']= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
                $data['pay_real']= $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
                $data['addtime']= $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
                $data['pay_refund']= $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
                $data['time_refund']= $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
                $data['note_refund']= $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
                $data['endtime']= $objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue();
                Db::table('fro_trade')->insert($data);
            }
            $this->success('导入成功！');
        }else
        {
            $this->error("请选择上传的文件");
        }
    }

    //商品文件导入
    public function goods_upload()
    {
        if (request()->file('upfile')) {
            $file = request()->file('upfile');
            $info = $file->validate(['size'=>3145728,'ext'=>'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info) {
                // 上传成功 获取上传文件信息
                $info->getExtension();
                $info->getSaveName();
                $info->getFilename();

            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }

            $extension = $info->getExtension();
            $file_name =  ROOT_PATH . 'public' . DS . 'uploads'  . DS . $info->getSaveName();

            vendor('Excel.PHPExcel');

            if( $extension =='xlsx' || $extension == 'xls') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            }
            else {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }

            //$objReader = \PHPExcel_IOFactory::createReader('Excel5');//创建读取实例

            $objPHPExcel = $objReader->load($file_name,$encode='utf-8');//加载文件
            $sheet = $objPHPExcel->getSheet(0);//取得sheet(0)表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            //\PHPExcel_Cell::columnIndexFromString(); //字母列转换为数字列 如:AA变为27
            for($i=2;$i<=$highestRow;$i++)
            {
                //$data['id']=$objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
                $data['name'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
                $tb['name'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
                $data['thumb']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                $data['price']= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
                $data['code']= $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
                $data['is_delete']= $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
                $cate['name']= $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
                Db::table('fro_goods')->insert($data);
                Db::table('fro_taobaostore')->insert($tb);
                Db::table('fro_category')->insert($cate);
            }
            $this->success('导入成功！');
        }else
        {
            $this->error("请选择上传的文件");
        }
    }

}

