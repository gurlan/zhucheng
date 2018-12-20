<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template("content","head"); ?>
<body>
<?php include template("content","logo"); ?>
<div class="content w1200 fix">
    <!--content_left-->
    <div class="content_left">
        <!--position-->
        <?php include template("content","position"); ?>
        <!--Contact-->
        <div class="Contact distance fix">
            <div class="Contact_tm fix"><h3>联系方式</h3></div>
            <div class="Contact_map fix" id="dituContent">

            </div>
            <div class="Contact_nr fix">
                <div class="Contact_tel">
                    <?php echo $content;?>
                </div>
                <div class="Contact_wx">
                    <ul>
                        <li><i><img src="<?php echo $sys['qrcode_a'];?>"/></i><span>筑城资本</span></li>
                        <li><i><img src="<?php echo $sys['qrcode_b'];?>"/></i><span>增益通科技</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--content_right-->
    <?php include template("content","right"); ?>
</div>

<?php include template("content","foot"); ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=56srZYI3vAB9XzW2B0u544hHhsdWdE7X"></script>

<script type="text/javascript">
    //创建和初始化地图函数：
    function initMap(){
        createMap();//创建地图
        setMapEvent();//设置地图事件
        addMapControl();//向地图添加控件
        addMapOverlay();//向地图添加覆盖物
    }
    function createMap(){
        map = new BMap.Map("dituContent");
        map.centerAndZoom(new BMap.Point(114.482947,38.052481),18);
    }
    function setMapEvent(){
        map.enableScrollWheelZoom();
        map.enableKeyboard();
        map.enableDragging();
        map.enableDoubleClickZoom()
    }
    function addClickHandler(target,window){
        target.addEventListener("click",function(){
            target.openInfoWindow(window);
        });
    }
    function addMapOverlay(){
        var markers = [

            {content:"筑城融创",title:"筑城融创",imageOffset: {width:-46,height:-21},position:{lat:38.052481,lng:114.482947}}
        ];
        for(var index = 0; index < markers.length; index++ ){
            var point = new BMap.Point(markers[index].position.lng,markers[index].position.lat);
            var marker = new BMap.Marker(point,{icon:new BMap.Icon("http://api.map.baidu.com/lbsapi/createmap/images/icon.png",new BMap.Size(20,25),{
                    imageOffset: new BMap.Size(markers[index].imageOffset.width,markers[index].imageOffset.height)
                })});
            var label = new BMap.Label(markers[index].title,{offset: new BMap.Size(25,5)});
            var opts = {
                width: 200,
                title: markers[index].title,
                enableMessage: false
            };
            var infoWindow = new BMap.InfoWindow(markers[index].content,opts);
            marker.setLabel(label);
            addClickHandler(marker,infoWindow);
            map.addOverlay(marker);
        };
    }
    //向地图添加控件
    function addMapControl(){
        var scaleControl = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
        scaleControl.setUnit(BMAP_UNIT_IMPERIAL);
        map.addControl(scaleControl);
        var navControl = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
        map.addControl(navControl);
        var overviewControl = new BMap.OverviewMapControl({anchor:BMAP_ANCHOR_BOTTOM_RIGHT,isOpen:true});
        map.addControl(overviewControl);
    }
    var map;
    initMap();
</script>
