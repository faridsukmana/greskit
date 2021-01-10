<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }

    $query = 'SELECT IT.item_id Item_ID, IT.item_description Item_Name, IB.brand_short_name Brand_Name, IC.item_category_description Category, IL.critical_level Critical_Level, IT.min Min, IT.max Max, IU.unit Unit, IT.stock Stock, IT.last_price Last_Price, IT.avg_price Avg_Price, IW.warehouse_name Warehouse, IT.qrpath, IE.id_location Location, IE.detail_location FROM invent_item IT, invent_brand IB, invent_item_categories IC, invent_critical_level IL, invent_unit IU, invent_warehouse IW, invent_location IE WHERE IT.brand_id=IB.brand_id AND IT.item_category_code=IC.item_category_code AND IT.critical_id=IL.critical_id AND IT.id_unit=IU.id_unit AND IT.warehouse_id=IW.warehouse_id AND IT.id_location=IE.id_location';

    $list='';
    $result = mysqli_query($con,$query); $list='';
    while($data = mysqli_fetch_assoc($result)){
        if($data['Stock']<$data['Min'] || $data['Stock']>$data['Max']){
            $list .= '
            <div class="item white mark border-red margin-button shadow">
                <div class="right">
                    <span class="text-small red radius padding" style="margin-left:2px;">'.$data['Min'].'</span>
                    <span class="text-small green radius padding" style="margin-left:2px;">'.$data['Max'].'</span>
                    <span class="text-small blue radius padding" style="margin-left:2px;">'.$data['Stock'].'</span>
                </div>
                <h2><strong>'.$data['Item_Name'].'</strong></h2>
                <p class="text-grey">'.$data['Item_ID'].'</p>
                <p class="text-red">'.$data['Category'].'</p>
                <p><a href="#" onclick="detail_inven(\''.$data['Item_ID'].'\')"><span class="text-small deep-orange radius padding">Detail</span></a></p>
            </div>';
        }else{
            $list .= '
            <div class="item white mark border-teal margin-button shadow">
                <div class="right">
                    <span class="text-small red radius padding" style="margin-left:2px;">'.$data['Min'].'</span>
                    <span class="text-small green radius padding" style="margin-left:2px;">'.$data['Max'].'</span>
                    <span class="text-small blue radius padding" style="margin-left:2px;">'.$data['Stock'].'</span>
                </div>
                <h2><strong>'.$data['Item_Name'].'</strong></h2>
                <p class="text-grey">'.$data['Item_ID'].'</p>
                <p class="text-teal">'.$data['Category'].'</p>
                <p><a href="#" onclick="detail_inven(\''.$data['Item_ID'].'\')"><span class="text-small deep-orange radius padding">Detail</span></a></p>
            </div>';
        }
    }

    $content = '<div class="list padding grey-100" id="list_wo">'.$list.'</div>';
    echo $content;
?>