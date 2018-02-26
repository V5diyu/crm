webpackJsonp([1],{

/***/ 518:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(633)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(545),
  /* template */
  __webpack_require__(606),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 543:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    props: ['prov', 'city'],
    data() {
        return {
            provs: [{ label: "北京市", value: "北京市" }, { label: "天津市", value: "天津市" }, { label: "河北省", value: "河北省" }, { label: "山西省", value: "山西省" }, { label: "内蒙古自治区", value: "内蒙古自治区" }, { label: "辽宁省", value: "辽宁省" }, { label: "吉林省", value: "吉林省" }, { label: "黑龙江省", value: "黑龙江省" }, { label: "上海市", value: "上海市" }, { label: "江苏省", value: "江苏省" }, { label: "浙江省", value: "浙江省" }, { label: "安徽省", value: "安徽省" }, { label: "福建省", value: "福建省" }, { label: "江西省", value: "江西省" }, { label: "山东省", value: "山东省" }, { label: "河南省", value: "河南省" }, { label: "湖北省", value: "湖北省" }, { label: "湖南省", value: "湖南省" }, { label: "广东省", value: "广东省" }, { label: "广西壮族自治区", value: "广西壮族自治区" }, { label: "海南省", value: "海南省" }, { label: "重庆市", value: "重庆市" }, { label: "四川省", value: "四川省" }, { label: "贵州省", value: "贵州省" }, { label: "云南省", value: "云南省" }, { label: "西藏自治区", value: "西藏自治区" }, { label: "陕西省", value: "陕西省" }, { label: "甘肃省", value: "甘肃省" }, { label: "青海省", value: "青海省" }, { label: "宁夏回族自治区", value: "宁夏回族自治区" }, { label: "新疆维吾尔自治区", value: "新疆维吾尔自治区" }, { label: "台湾省", value: "台湾省" }, { label: "香港特别行政区", value: "香港特别行政区" }, { label: "澳门特别行政区", value: "澳门特别行政区" }],
            citys: [],
            selectProv: this.prov,
            selectCity: this.city
        };
    },
    methods: {
        /*二级联动选择地区*/
        getProv: function (prov) {
            let tempCity = [];
            this.citys = [];
            this.selectCity = '';
            let allCity = [{
                prov: "北京市",
                label: "北京市"
            }, {
                prov: "天津市",
                label: "天津市"
            }, {
                prov: "河北省",
                label: "石家庄市"
            }, {
                prov: "河北省",
                label: "唐山市"
            }, {
                prov: "河北省",
                label: "秦皇岛市"
            }, {
                prov: "河北省",
                label: "邯郸市"
            }, {
                prov: "河北省",
                label: "邢台市"
            }, {
                prov: "河北省",
                label: "保定市"
            }, {
                prov: "河北省",
                label: "张家口市"
            }, {
                prov: "河北省",
                label: "承德市"
            }, {
                prov: "河北省",
                label: "沧州市"
            }, {
                prov: "河北省",
                label: "廊坊市"
            }, {
                prov: "河北省",
                label: "衡水市"
            }, {
                prov: "山西省",
                label: "太原市"
            }, {
                prov: "山西省",
                label: "大同市"
            }, {
                prov: "山西省",
                label: "阳泉市"
            }, {
                prov: "山西省",
                label: "长治市"
            }, {
                prov: "山西省",
                label: "晋城市"
            }, {
                prov: "山西省",
                label: "朔州市"
            }, {
                prov: "山西省",
                label: "晋中市"
            }, {
                prov: "山西省",
                label: "运城市"
            }, {
                prov: "山西省",
                label: "忻州市"
            }, {
                prov: "山西省",
                label: "临汾市"
            }, {
                prov: "山西省",
                label: "吕梁市"
            }, {
                prov: "内蒙古自治区",
                label: "呼和浩特市"
            }, {
                prov: "内蒙古自治区",
                label: "包头市"
            }, {
                prov: "内蒙古自治区",
                label: "乌海市"
            }, {
                prov: "内蒙古自治区",
                label: "赤峰市"
            }, {
                prov: "内蒙古自治区",
                label: "通辽市"
            }, {
                prov: "内蒙古自治区",
                label: "鄂尔多斯市"
            }, {
                prov: "内蒙古自治区",
                label: "呼伦贝尔市"
            }, {
                prov: "内蒙古自治区",
                label: "巴彦淖尔市"
            }, {
                prov: "内蒙古自治区",
                label: "乌兰察布市"
            }, {
                prov: "内蒙古自治区",
                label: "兴安盟"
            }, {
                prov: "内蒙古自治区",
                label: "锡林郭勒盟"
            }, {
                prov: "内蒙古自治区",
                label: "阿拉善盟"
            }, {
                prov: "辽宁省",
                label: "沈阳市"
            }, {
                prov: "辽宁省",
                label: "大连市"
            }, {
                prov: "辽宁省",
                label: "鞍山市"
            }, {
                prov: "辽宁省",
                label: "抚顺市"
            }, {
                prov: "辽宁省",
                label: "本溪市"
            }, {
                prov: "辽宁省",
                label: "丹东市"
            }, {
                prov: "辽宁省",
                label: "锦州市"
            }, {
                prov: "辽宁省",
                label: "营口市"
            }, {
                prov: "辽宁省",
                label: "阜新市"
            }, {
                prov: "辽宁省",
                label: "辽阳市"
            }, {
                prov: "辽宁省",
                label: "盘锦市"
            }, {
                prov: "辽宁省",
                label: "铁岭市"
            }, {
                prov: "辽宁省",
                label: "朝阳市"
            }, {
                prov: "辽宁省",
                label: "葫芦岛市"
            }, {
                prov: "吉林省",
                label: "长春市"
            }, {
                prov: "吉林省",
                label: "吉林市"
            }, {
                prov: "吉林省",
                label: "四平市"
            }, {
                prov: "吉林省",
                label: "辽源市"
            }, {
                prov: "吉林省",
                label: "通化市"
            }, {
                prov: "吉林省",
                label: "白山市"
            }, {
                prov: "吉林省",
                label: "松原市"
            }, {
                prov: "吉林省",
                label: "白城市"
            }, {
                prov: "吉林省",
                label: "延边朝鲜族自治州"
            }, {
                prov: "黑龙江省",
                label: "哈尔滨市"
            }, {
                prov: "黑龙江省",
                label: "齐齐哈尔市"
            }, {
                prov: "黑龙江省",
                label: "鸡西市"
            }, {
                prov: "黑龙江省",
                label: "鹤岗市"
            }, {
                prov: "黑龙江省",
                label: "双鸭山市"
            }, {
                prov: "黑龙江省",
                label: "大庆市"
            }, {
                prov: "黑龙江省",
                label: "伊春市"
            }, {
                prov: "黑龙江省",
                label: "佳木斯市"
            }, {
                prov: "黑龙江省",
                label: "七台河市"
            }, {
                prov: "黑龙江省",
                label: "牡丹江市"
            }, {
                prov: "黑龙江省",
                label: "黑河市"
            }, {
                prov: "黑龙江省",
                label: "绥化市"
            }, {
                prov: "黑龙江省",
                label: "大兴安岭地区"
            }, {
                prov: "上海市",
                label: "上海市"
            }, {
                prov: "江苏省",
                label: "南京市"
            }, {
                prov: "江苏省",
                label: "无锡市"
            }, {
                prov: "江苏省",
                label: "徐州市"
            }, {
                prov: "江苏省",
                label: "常州市"
            }, {
                prov: "江苏省",
                label: "苏州市"
            }, {
                prov: "江苏省",
                label: "南通市"
            }, {
                prov: "江苏省",
                label: "连云港市"
            }, {
                prov: "江苏省",
                label: "淮安市"
            }, {
                prov: "江苏省",
                label: "盐城市"
            }, {
                prov: "江苏省",
                label: "扬州市"
            }, {
                prov: "江苏省",
                label: "镇江市"
            }, {
                prov: "江苏省",
                label: "泰州市"
            }, {
                prov: "江苏省",
                label: "宿迁市"
            }, {
                prov: "浙江省",
                label: "杭州市"
            }, {
                prov: "浙江省",
                label: "宁波市"
            }, {
                prov: "浙江省",
                label: "温州市"
            }, {
                prov: "浙江省",
                label: "嘉兴市"
            }, {
                prov: "浙江省",
                label: "湖州市"
            }, {
                prov: "浙江省",
                label: "绍兴市"
            }, {
                prov: "浙江省",
                label: "金华市"
            }, {
                prov: "浙江省",
                label: "衢州市"
            }, {
                prov: "浙江省",
                label: "舟山市"
            }, {
                prov: "浙江省",
                label: "台州市"
            }, {
                prov: "浙江省",
                label: "丽水市"
            }, {
                prov: "安徽省",
                label: "合肥市"
            }, {
                prov: "安徽省",
                label: "芜湖市"
            }, {
                prov: "安徽省",
                label: "蚌埠市"
            }, {
                prov: "安徽省",
                label: "淮南市"
            }, {
                prov: "安徽省",
                label: "马鞍山市"
            }, {
                prov: "安徽省",
                label: "淮北市"
            }, {
                prov: "安徽省",
                label: "铜陵市"
            }, {
                prov: "安徽省",
                label: "安庆市"
            }, {
                prov: "安徽省",
                label: "黄山市"
            }, {
                prov: "安徽省",
                label: "滁州市"
            }, {
                prov: "安徽省",
                label: "阜阳市"
            }, {
                prov: "安徽省",
                label: "宿州市"
            }, {
                prov: "安徽省",
                label: "六安市"
            }, {
                prov: "安徽省",
                label: "亳州市"
            }, {
                prov: "安徽省",
                label: "池州市"
            }, {
                prov: "安徽省",
                label: "宣城市"
            }, {
                prov: "福建省",
                label: "福州市"
            }, {
                prov: "福建省",
                label: "厦门市"
            }, {
                prov: "福建省",
                label: "莆田市"
            }, {
                prov: "福建省",
                label: "三明市"
            }, {
                prov: "福建省",
                label: "泉州市"
            }, {
                prov: "福建省",
                label: "漳州市"
            }, {
                prov: "福建省",
                label: "南平市"
            }, {
                prov: "福建省",
                label: "龙岩市"
            }, {
                prov: "福建省",
                label: "宁德市"
            }, {
                prov: "江西省",
                label: "南昌市"
            }, {
                prov: "江西省",
                label: "景德镇市"
            }, {
                prov: "江西省",
                label: "萍乡市"
            }, {
                prov: "江西省",
                label: "九江市"
            }, {
                prov: "江西省",
                label: "新余市"
            }, {
                prov: "江西省",
                label: "鹰潭市"
            }, {
                prov: "江西省",
                label: "赣州市"
            }, {
                prov: "江西省",
                label: "吉安市"
            }, {
                prov: "江西省",
                label: "宜春市"
            }, {
                prov: "江西省",
                label: "抚州市"
            }, {
                prov: "江西省",
                label: "上饶市"
            }, {
                prov: "山东省",
                label: "济南市"
            }, {
                prov: "山东省",
                label: "青岛市"
            }, {
                prov: "山东省",
                label: "淄博市"
            }, {
                prov: "山东省",
                label: "枣庄市"
            }, {
                prov: "山东省",
                label: "东营市"
            }, {
                prov: "山东省",
                label: "烟台市"
            }, {
                prov: "山东省",
                label: "潍坊市"
            }, {
                prov: "山东省",
                label: "济宁市"
            }, {
                prov: "山东省",
                label: "泰安市"
            }, {
                prov: "山东省",
                label: "威海市"
            }, {
                prov: "山东省",
                label: "日照市"
            }, {
                prov: "山东省",
                label: "莱芜市"
            }, {
                prov: "山东省",
                label: "临沂市"
            }, {
                prov: "山东省",
                label: "德州市"
            }, {
                prov: "山东省",
                label: "聊城市"
            }, {
                prov: "山东省",
                label: "滨州市"
            }, {
                prov: "山东省",
                label: "菏泽市"
            }, {
                prov: "河南省",
                label: "郑州市"
            }, {
                prov: "河南省",
                label: "开封市"
            }, {
                prov: "河南省",
                label: "洛阳市"
            }, {
                prov: "河南省",
                label: "平顶山市"
            }, {
                prov: "河南省",
                label: "安阳市"
            }, {
                prov: "河南省",
                label: "鹤壁市"
            }, {
                prov: "河南省",
                label: "新乡市"
            }, {
                prov: "河南省",
                label: "焦作市"
            }, {
                prov: "河南省",
                label: "濮阳市"
            }, {
                prov: "河南省",
                label: "许昌市"
            }, {
                prov: "河南省",
                label: "漯河市"
            }, {
                prov: "河南省",
                label: "三门峡市"
            }, {
                prov: "河南省",
                label: "南阳市"
            }, {
                prov: "河南省",
                label: "商丘市"
            }, {
                prov: "河南省",
                label: "信阳市"
            }, {
                prov: "河南省",
                label: "周口市"
            }, {
                prov: "河南省",
                label: "驻马店市"
            }, {
                prov: "河南省",
                label: "省直辖县级行政区划"
            }, {
                prov: "湖北省",
                label: "武汉市"
            }, {
                prov: "湖北省",
                label: "黄石市"
            }, {
                prov: "湖北省",
                label: "十堰市"
            }, {
                prov: "湖北省",
                label: "宜昌市"
            }, {
                prov: "湖北省",
                label: "襄阳市"
            }, {
                prov: "湖北省",
                label: "鄂州市"
            }, {
                prov: "湖北省",
                label: "荆门市"
            }, {
                prov: "湖北省",
                label: "孝感市"
            }, {
                prov: "湖北省",
                label: "荆州市"
            }, {
                prov: "湖北省",
                label: "黄冈市"
            }, {
                prov: "湖北省",
                label: "咸宁市"
            }, {
                prov: "湖北省",
                label: "随州市"
            }, {
                prov: "湖北省",
                label: "恩施土家族苗族自治州"
            }, {
                prov: "湖北省",
                label: "省直辖县级行政区划"
            }, {
                prov: "湖北省",
                label: "仙桃市"
            }, {
                prov: "湖北省",
                label: "潜江市"
            }, {
                prov: "湖北省",
                label: "天门市"
            }, {
                prov: "湖北省",
                label: "神农架林区"
            }, {
                prov: "湖南省",
                label: "长沙市"
            }, {
                prov: "湖南省",
                label: "株洲市"
            }, {
                prov: "湖南省",
                label: "湘潭市"
            }, {
                prov: "湖南省",
                label: "衡阳市"
            }, {
                prov: "湖南省",
                label: "邵阳市"
            }, {
                prov: "湖南省",
                label: "岳阳市"
            }, {
                prov: "湖南省",
                label: "常德市"
            }, {
                prov: "湖南省",
                label: "张家界市"
            }, {
                prov: "湖南省",
                label: "益阳市"
            }, {
                prov: "湖南省",
                label: "郴州市"
            }, {
                prov: "湖南省",
                label: "永州市"
            }, {
                prov: "湖南省",
                label: "怀化市"
            }, {
                prov: "湖南省",
                label: "娄底市"
            }, {
                prov: "湖南省",
                label: "湘西土家族苗族自治州"
            }, {
                prov: "广东省",
                label: "广州市"
            }, {
                prov: "广东省",
                label: "韶关市"
            }, {
                prov: "广东省",
                label: "深圳市"
            }, {
                prov: "广东省",
                label: "珠海市"
            }, {
                prov: "广东省",
                label: "汕头市"
            }, {
                prov: "广东省",
                label: "佛山市"
            }, {
                prov: "广东省",
                label: "江门市"
            }, {
                prov: "广东省",
                label: "湛江市"
            }, {
                prov: "广东省",
                label: "茂名市"
            }, {
                prov: "广东省",
                label: "肇庆市"
            }, {
                prov: "广东省",
                label: "惠州市"
            }, {
                prov: "广东省",
                label: "梅州市"
            }, {
                prov: "广东省",
                label: "汕尾市"
            }, {
                prov: "广东省",
                label: "河源市"
            }, {
                prov: "广东省",
                label: "阳江市"
            }, {
                prov: "广东省",
                label: "清远市"
            }, {
                prov: "广东省",
                label: "东莞市"
            }, {
                prov: "广东省",
                label: "中山市"
            }, {
                prov: "广东省",
                label: "潮州市"
            }, {
                prov: "广东省",
                label: "揭阳市"
            }, {
                prov: "广东省",
                label: "云浮市"
            }, {
                prov: "广西壮族自治区",
                label: "南宁市"
            }, {
                prov: "广西壮族自治区",
                label: "柳州市"
            }, {
                prov: "广西壮族自治区",
                label: "桂林市"
            }, {
                prov: "广西壮族自治区",
                label: "梧州市"
            }, {
                prov: "广西壮族自治区",
                label: "北海市"
            }, {
                prov: "广西壮族自治区",
                label: "防城港市"
            }, {
                prov: "广西壮族自治区",
                label: "钦州市"
            }, {
                prov: "广西壮族自治区",
                label: "贵港市"
            }, {
                prov: "广西壮族自治区",
                label: "玉林市"
            }, {
                prov: "广西壮族自治区",
                label: "百色市"
            }, {
                prov: "广西壮族自治区",
                label: "贺州市"
            }, {
                prov: "广西壮族自治区",
                label: "河池市"
            }, {
                prov: "广西壮族自治区",
                label: "来宾市"
            }, {
                prov: "广西壮族自治区",
                label: "崇左市"
            }, {
                prov: "海南省",
                label: "海口市"
            }, {
                prov: "海南省",
                label: "三亚市"
            }, {
                prov: "海南省",
                label: "三沙市"
            }, {
                prov: "海南省",
                label: "省直辖县级行政区划"
            }, {
                prov: "海南省",
                label: "五指山市"
            }, {
                prov: "海南省",
                label: "琼海市"
            }, {
                prov: "海南省",
                label: "儋州市"
            }, {
                prov: "海南省",
                label: "文昌市"
            }, {
                prov: "海南省",
                label: "万宁市"
            }, {
                prov: "海南省",
                label: "东方市"
            }, {
                prov: "海南省",
                label: "定安县"
            }, {
                prov: "海南省",
                label: "屯昌县"
            }, {
                prov: "海南省",
                label: "澄迈县"
            }, {
                prov: "海南省",
                label: "临高县"
            }, {
                prov: "海南省",
                label: "白沙黎族自治县"
            }, {
                prov: "海南省",
                label: "昌江黎族自治县"
            }, {
                prov: "海南省",
                label: "乐东黎族自治县"
            }, {
                prov: "海南省",
                label: "陵水黎族自治县"
            }, {
                prov: "海南省",
                label: "保亭黎族苗族自治县"
            }, {
                prov: "海南省",
                label: "琼中黎族苗族自治县"
            }, {
                prov: "重庆市",
                label: "重庆市"
            }, {
                prov: "四川省",
                label: "成都市"
            }, {
                prov: "四川省",
                label: "自贡市"
            }, {
                prov: "四川省",
                label: "攀枝花市"
            }, {
                prov: "四川省",
                label: "泸州市"
            }, {
                prov: "四川省",
                label: "德阳市"
            }, {
                prov: "四川省",
                label: "绵阳市"
            }, {
                prov: "四川省",
                label: "广元市"
            }, {
                prov: "四川省",
                label: "遂宁市"
            }, {
                prov: "四川省",
                label: "内江市"
            }, {
                prov: "四川省",
                label: "乐山市"
            }, {
                prov: "四川省",
                label: "南充市"
            }, {
                prov: "四川省",
                label: "眉山市"
            }, {
                prov: "四川省",
                label: "宜宾市"
            }, {
                prov: "四川省",
                label: "广安市"
            }, {
                prov: "四川省",
                label: "达州市"
            }, {
                prov: "四川省",
                label: "雅安市"
            }, {
                prov: "四川省",
                label: "巴中市"
            }, {
                prov: "四川省",
                label: "资阳市"
            }, {
                prov: "四川省",
                label: "阿坝藏族羌族自治州"
            }, {
                prov: "四川省",
                label: "甘孜藏族自治州"
            }, {
                prov: "四川省",
                label: "凉山彝族自治州"
            }, {
                prov: "贵州省",
                label: "贵阳市"
            }, {
                prov: "贵州省",
                label: "六盘水市"
            }, {
                prov: "贵州省",
                label: "遵义市"
            }, {
                prov: "贵州省",
                label: "安顺市"
            }, {
                prov: "贵州省",
                label: "毕节市"
            }, {
                prov: "贵州省",
                label: "铜仁市"
            }, {
                prov: "贵州省",
                label: "黔西南布依族苗族自治州"
            }, {
                prov: "贵州省",
                label: "黔东南苗族侗族自治州"
            }, {
                prov: "贵州省",
                label: "黔南布依族苗族自治州"
            }, {
                prov: "云南省",
                label: "昆明市"
            }, {
                prov: "云南省",
                label: "曲靖市"
            }, {
                prov: "云南省",
                label: "玉溪市"
            }, {
                prov: "云南省",
                label: "保山市"
            }, {
                prov: "云南省",
                label: "昭通市"
            }, {
                prov: "云南省",
                label: "丽江市"
            }, {
                prov: "云南省",
                label: "普洱市"
            }, {
                prov: "云南省",
                label: "临沧市"
            }, {
                prov: "云南省",
                label: "楚雄彝族自治州"
            }, {
                prov: "云南省",
                label: "红河哈尼族彝族自治州"
            }, {
                prov: "云南省",
                label: "文山壮族苗族自治州"
            }, {
                prov: "云南省",
                label: "西双版纳傣族自治州"
            }, {
                prov: "云南省",
                label: "大理白族自治州"
            }, {
                prov: "云南省",
                label: "德宏傣族景颇族自治州"
            }, {
                prov: "云南省",
                label: "怒江傈僳族自治州"
            }, {
                prov: "云南省",
                label: "迪庆藏族自治州"
            }, {
                prov: "西藏自治区",
                label: "拉萨市"
            }, {
                prov: "西藏自治区",
                label: "昌都地区"
            }, {
                prov: "西藏自治区",
                label: "山南地区"
            }, {
                prov: "西藏自治区",
                label: "日喀则地区"
            }, {
                prov: "西藏自治区",
                label: "那曲地区"
            }, {
                prov: "西藏自治区",
                label: "阿里地区"
            }, {
                prov: "西藏自治区",
                label: "林芝地区"
            }, {
                prov: "陕西省",
                label: "西安市"
            }, {
                prov: "陕西省",
                label: "铜川市"
            }, {
                prov: "陕西省",
                label: "宝鸡市"
            }, {
                prov: "陕西省",
                label: "咸阳市"
            }, {
                prov: "陕西省",
                label: "渭南市"
            }, {
                prov: "陕西省",
                label: "延安市"
            }, {
                prov: "陕西省",
                label: "汉中市"
            }, {
                prov: "陕西省",
                label: "榆林市"
            }, {
                prov: "陕西省",
                label: "安康市"
            }, {
                prov: "陕西省",
                label: "商洛市"
            }, {
                prov: "甘肃省",
                label: "兰州市"
            }, {
                prov: "甘肃省",
                label: "嘉峪关市"
            }, {
                prov: "甘肃省",
                label: "金昌市"
            }, {
                prov: "甘肃省",
                label: "白银市"
            }, {
                prov: "甘肃省",
                label: "天水市"
            }, {
                prov: "甘肃省",
                label: "武威市"
            }, {
                prov: "甘肃省",
                label: "张掖市"
            }, {
                prov: "甘肃省",
                label: "平凉市"
            }, {
                prov: "甘肃省",
                label: "酒泉市"
            }, {
                prov: "甘肃省",
                label: "庆阳市"
            }, {
                prov: "甘肃省",
                label: "定西市"
            }, {
                prov: "甘肃省",
                label: "陇南市"
            }, {
                prov: "甘肃省",
                label: "临夏回族自治州"
            }, {
                prov: "甘肃省",
                label: "甘南藏族自治州"
            }, {
                prov: "青海省",
                label: "西宁市"
            }, {
                prov: "青海省",
                label: "海东市"
            }, {
                prov: "青海省",
                label: "海北藏族自治州"
            }, {
                prov: "青海省",
                label: "黄南藏族自治州"
            }, {
                prov: "青海省",
                label: "海南藏族自治州"
            }, {
                prov: "青海省",
                label: "果洛藏族自治州"
            }, {
                prov: "青海省",
                label: "玉树藏族自治州"
            }, {
                prov: "青海省",
                label: "海西蒙古族藏族自治州"
            }, {
                prov: "宁夏回族自治区",
                label: "银川市"
            }, {
                prov: "宁夏回族自治区",
                label: "石嘴山市"
            }, {
                prov: "宁夏回族自治区",
                label: "吴忠市"
            }, {
                prov: "宁夏回族自治区",
                label: "固原市"
            }, {
                prov: "宁夏回族自治区",
                label: "中卫市"
            }, {
                prov: "新疆维吾尔自治区",
                label: "乌鲁木齐市"
            }, {
                prov: "新疆维吾尔自治区",
                label: "克拉玛依市"
            }, {
                prov: "新疆维吾尔自治区",
                label: "吐鲁番地区"
            }, {
                prov: "新疆维吾尔自治区",
                label: "哈密地区"
            }, {
                prov: "新疆维吾尔自治区",
                label: "昌吉回族自治州"
            }, {
                prov: "新疆维吾尔自治区",
                label: "博尔塔拉蒙古自治州"
            }, {
                prov: "新疆维吾尔自治区",
                label: "巴音郭楞蒙古自治州"
            }, {
                prov: "新疆维吾尔自治区",
                label: "阿克苏地区"
            }, {
                prov: "新疆维吾尔自治区",
                label: "克孜勒苏柯尔克孜自治州"
            }, {
                prov: "新疆维吾尔自治区",
                label: "喀什地区"
            }, {
                prov: "新疆维吾尔自治区",
                label: "和田地区"
            }, {
                prov: "新疆维吾尔自治区",
                label: "伊犁哈萨克自治州"
            }, {
                prov: "新疆维吾尔自治区",
                label: "塔城地区"
            }, {
                prov: "新疆维吾尔自治区",
                label: "阿勒泰地区"
            }, {
                prov: "新疆维吾尔自治区",
                label: "自治区直辖县级行政区划"
            }, {
                prov: "新疆维吾尔自治区",
                label: "石河子市"
            }, {
                prov: "新疆维吾尔自治区",
                label: "阿拉尔市"
            }, {
                prov: "新疆维吾尔自治区",
                label: "图木舒克市"
            }, {
                prov: "新疆维吾尔自治区",
                label: "五家渠市"
            }, {
                prov: "台湾省",
                label: "台北市"
            }, {
                prov: "台湾省",
                label: "高雄市"
            }, {
                prov: "台湾省",
                label: "基隆市"
            }, {
                prov: "台湾省",
                label: "台中市"
            }, {
                prov: "台湾省",
                label: "台南市"
            }, {
                prov: "台湾省",
                label: "新竹市"
            }, {
                prov: "台湾省",
                label: "嘉义市"
            }, {
                prov: "台湾省",
                label: "省直辖"
            }, {
                prov: "香港特别行政区",
                label: "香港岛"
            }, {
                prov: "香港特别行政区",
                label: "九龙"
            }, {
                prov: "香港特别行政区",
                label: "新界"
            }, {
                prov: "澳门特别行政区",
                label: "澳门半岛"
            }, {
                prov: "澳门特别行政区",
                label: "澳门离岛"
            }, {
                prov: "澳门特别行政区",
                label: "无堂区划分区域"
            }];
            for (var val of allCity) {
                if (prov == val.prov) {
                    // console.log(val);  
                    tempCity.push({ label: val.label, value: val.label });
                }
            }
            this.citys = tempCity;
        },
        getCity: function (city) {
            // console.log(city);  
            // console.log(this.selectCity)  
            // console.log(this.selectProv , this.selectCity)
        }

    },
    watch: {
        prov(val) {
            this.selectProv = val;
        },
        city(val) {
            this.$nextTick(() => {
                this.selectCity = val;
            });
        }
    },
    mounted: function () {
        console.log(this.prov);
    },
    updated: function () {}
});

/***/ }),

/***/ 545:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__TestCitySmarty_vue__ = __webpack_require__(596);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__TestCitySmarty_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__TestCitySmarty_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
    components: {
        vCity: __WEBPACK_IMPORTED_MODULE_0__TestCitySmarty_vue___default.a
    },
    data() {
        return {
            form: {
                type: 1, //1:终端  2:厂家
                code: '',
                name: '', //客户名称
                province: '', //省
                city: '', //市
                address: '', //地址
                stage: '', //客户阶段
                explain: '', //其他情况说明
                intermediaryCompany: '', //中间公司
                // salesperson: '',              //跟进销售员
                mainPersonnel: [{}], //主要人员{'duties':'','name':'','phone':'','remarks':''}
                salesFunnel: '', //销售漏斗{'stage':'','remarks':'','time':''}
                cooperationSituation: [{}], //合作情况{'historical':'','income'：''}
                abbreviation: '', //简称
                legalRepresentative: '', //法定代表人
                registeredCapital: '', //注册资金
                lastYearSales: '', //去年年销售额
                customerRating: '' //客户评级
            },
            options: [{
                key: '初步接触',
                value: '初步接触'
            }, {
                key: '有兴趣',
                value: '有兴趣'
            }, {
                key: '询问价格',
                value: '询问价格'
            }, {
                key: '提交方案',
                value: '提交方案'
            }, {
                key: '下订单',
                value: '下订单'
            }, {
                key: '成交',
                value: '成交'
            }, {
                key: '丢单',
                value: '丢单'
            }]
        };
    },
    created() {
        if (this.$route.query.id) {
            this.getData();
        }
    },
    methods: {
        initData(val) {
            this.form = {
                type: val, //1:终端  2:厂家
                code: '',
                name: '', //客户名称
                province: '', //省
                city: '', //市
                address: '', //地址
                stage: '', //客户阶段
                explain: '', //其他情况说明
                intermediaryCompany: '', //中间公司
                // salesperson: '',              //跟进销售员
                mainPersonnel: [{}], //主要人员{'duties':'','name':'','phone':'','remarks':''}
                salesFunnel: '', //销售漏斗{'stage':'','remarks':'','time':''}
                cooperationSituation: [{}], //合作情况{'historical':'','income'：''}
                abbreviation: '', //简称
                legalRepresentative: '', //法定代表人
                registeredCapital: '', //注册资金
                lastYearSales: '', //去年年销售额
                customerRating: '' //客户评级
            };
        },
        getData() {
            this.$axios.post('getCustomerById', {
                id: this.$route.query.id
            }, res => {
                if (res.ret == true) {
                    this.form = res.data;
                }
            });
        },
        // 新增主要人员
        addMainPersonnel() {
            this.form.mainPersonnel.push({});
        },
        addCooperationSituation() {
            this.form.cooperationSituation.push({});
        },
        add() {
            let self = this;
            this.form.province = this.$refs.vCity.selectProv;
            this.form.city = this.$refs.vCity.selectCity;
            console.log(this.form);

            if (this.$route.query.id) {
                this.$axios.post('updateCustomer', self.form, res => {
                    if (res.ret == true) {
                        self.$message.success('修改成功');
                    }
                });
            } else {
                this.$axios.post('addCustomer', self.form, res => {
                    if (res.ret == true) {
                        self.initData(self.form.type);
                        self.$message.success('添加成功');
                    }
                });
            }
        }
    }
});

/***/ }),

/***/ 576:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".section-header{height:40px;line-height:40px;border-top:6px solid #e8e8e8;color:#999;font-size:14px}.mainForm .mainPerson input{width:400px}.mainForm input{width:600px}", ""]);

// exports


/***/ }),

/***/ 577:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(65)();
// imports


// module
exports.push([module.i, ".testCitySmarty .el-col{margin-right:20px}", ""]);

// exports


/***/ }),

/***/ 596:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(634)

var Component = __webpack_require__(201)(
  /* script */
  __webpack_require__(543),
  /* template */
  __webpack_require__(607),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 606:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "table"
  }, [_c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-breadcrumb', {
    attrs: {
      "separator": "/"
    }
  }, [_c('el-breadcrumb-item', [_c('i', {
    staticClass: "el-icon-menu"
  }), _vm._v(" 客户管理")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("客户池")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v(_vm._s(_vm.$route.query.id ? '修改客户' : '新增客户'))])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-form', {
    ref: "form",
    staticClass: "mainForm",
    attrs: {
      "model": _vm.form,
      "label-position": "left",
      "label-width": "100px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "客户类型"
    }
  }, [_c('el-radio-group', {
    model: {
      value: (_vm.form.type),
      callback: function($$v) {
        _vm.$set(_vm.form, "type", $$v)
      },
      expression: "form.type"
    }
  }, [_c('el-radio-button', {
    attrs: {
      "label": "1"
    }
  }, [_vm._v("终端")]), _vm._v(" "), _c('el-radio-button', {
    attrs: {
      "label": "2"
    }
  }, [_vm._v("厂家")])], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "section-header"
  }, [_vm._v("基本信息")]), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.form.type == 1),
      expression: "form.type == 1"
    }],
    staticClass: "baseInfo"
  }, [_c('el-form-item', {
    attrs: {
      "label": "名称"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.name),
      callback: function($$v) {
        _vm.$set(_vm.form, "name", $$v)
      },
      expression: "form.name"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "编号"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.code),
      callback: function($$v) {
        _vm.$set(_vm.form, "code", $$v)
      },
      expression: "form.code"
    }
  })], 1), _vm._v(" "), _c('v-city', {
    ref: "vCity",
    attrs: {
      "prov": _vm.form.province,
      "city": _vm.form.city
    },
    on: {
      "update:city": function($event) {
        _vm.$set(_vm.form, "city", $event)
      }
    }
  }), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "地址"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.address),
      callback: function($$v) {
        _vm.$set(_vm.form, "address", $$v)
      },
      expression: "form.address"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "阶段"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.stage),
      callback: function($$v) {
        _vm.$set(_vm.form, "stage", $$v)
      },
      expression: "form.stage"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "其他情况说明"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.explain),
      callback: function($$v) {
        _vm.$set(_vm.form, "explain", $$v)
      },
      expression: "form.explain"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "中间公司"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.intermediaryCompany),
      callback: function($$v) {
        _vm.$set(_vm.form, "intermediaryCompany", $$v)
      },
      expression: "form.intermediaryCompany"
    }
  })], 1)], 1), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.form.type == 2),
      expression: "form.type == 2"
    }],
    staticClass: "baseInfo"
  }, [_c('el-form-item', {
    attrs: {
      "label": "名称"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.name),
      callback: function($$v) {
        _vm.$set(_vm.form, "name", $$v)
      },
      expression: "form.name"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "编号"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.code),
      callback: function($$v) {
        _vm.$set(_vm.form, "code", $$v)
      },
      expression: "form.code"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "简称"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.abbreviation),
      callback: function($$v) {
        _vm.$set(_vm.form, "abbreviation", $$v)
      },
      expression: "form.abbreviation"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "法定代表人"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.legalRepresentative),
      callback: function($$v) {
        _vm.$set(_vm.form, "legalRepresentative", $$v)
      },
      expression: "form.legalRepresentative"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "注册资金/万"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.registeredCapital),
      callback: function($$v) {
        _vm.$set(_vm.form, "registeredCapital", $$v)
      },
      expression: "form.registeredCapital"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "去年销售额"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.lastYearSales),
      callback: function($$v) {
        _vm.$set(_vm.form, "lastYearSales", $$v)
      },
      expression: "form.lastYearSales"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "评级"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.customerRating),
      callback: function($$v) {
        _vm.$set(_vm.form, "customerRating", $$v)
      },
      expression: "form.customerRating"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "其他情况说明"
    }
  }, [_c('el-input', {
    model: {
      value: (_vm.form.explain),
      callback: function($$v) {
        _vm.$set(_vm.form, "explain", $$v)
      },
      expression: "form.explain"
    }
  })], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "section-header"
  }, [_vm._v("主要人员")]), _vm._v(" "), _vm._l((_vm.form.mainPersonnel), function(item, index) {
    return _c('div', {
      staticClass: "mainPerson",
      staticStyle: {
        "border-bottom": "1px dashed #e8e8e8",
        "margin-bottom": "20px"
      }
    }, [_c('el-form-item', {
      attrs: {
        "label": "职务"
      }
    }, [_c('el-input', {
      model: {
        value: (item.duties),
        callback: function($$v) {
          _vm.$set(item, "duties", $$v)
        },
        expression: "item.duties"
      }
    })], 1), _vm._v(" "), _c('el-form-item', {
      attrs: {
        "label": "姓名"
      }
    }, [_c('el-input', {
      model: {
        value: (item.name),
        callback: function($$v) {
          _vm.$set(item, "name", $$v)
        },
        expression: "item.name"
      }
    })], 1), _vm._v(" "), _c('el-form-item', {
      attrs: {
        "label": "电话"
      }
    }, [_c('el-input', {
      model: {
        value: (item.phone),
        callback: function($$v) {
          _vm.$set(item, "phone", $$v)
        },
        expression: "item.phone"
      }
    })], 1), _vm._v(" "), _c('el-form-item', {
      attrs: {
        "label": "备注"
      }
    }, [_c('el-input', {
      model: {
        value: (item.remarks),
        callback: function($$v) {
          _vm.$set(item, "remarks", $$v)
        },
        expression: "item.remarks"
      }
    })], 1)], 1)
  }), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": ""
    }
  }, [_c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.addMainPersonnel
    }
  }, [_vm._v("新增主要人员")])], 1), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.form.type == 1),
      expression: "form.type == 1"
    }],
    staticStyle: {
      "margin-bottom": "30px"
    }
  }, [_c('div', {
    staticClass: "section-header"
  }, [_vm._v("销售漏斗")]), _vm._v(" "), _c('el-select', {
    attrs: {
      "placeholder": "请选择"
    },
    model: {
      value: (_vm.form.salesFunnel),
      callback: function($$v) {
        _vm.$set(_vm.form, "salesFunnel", $$v)
      },
      expression: "form.salesFunnel"
    }
  }, _vm._l((_vm.options), function(item) {
    return _c('el-option', {
      key: item.value,
      attrs: {
        "label": item.key,
        "value": item.value
      }
    })
  }))], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": ""
    }
  }, [_c('el-button', {
    attrs: {
      "type": "success",
      "size": "large"
    },
    on: {
      "click": _vm.add
    }
  }, [_vm._v("提交")])], 1)], 2)], 1)])
},staticRenderFns: []}

/***/ }),

/***/ 607:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "testCitySmarty"
  }, [_c('el-form', {
    attrs: {
      "label-width": "100px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "省份"
    }
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 24
    }
  }, [_c('el-select', {
    attrs: {
      "size": "",
      "placeholder": "请选择省份"
    },
    on: {
      "change": function($event) {
        _vm.getProv($event)
      }
    },
    model: {
      value: (_vm.selectProv),
      callback: function($$v) {
        _vm.selectProv = $$v
      },
      expression: "selectProv"
    }
  }, _vm._l((_vm.provs), function(item) {
    return _c('el-option', {
      attrs: {
        "label": item.label,
        "value": item.value
      }
    })
  }))], 1)], 1)], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "城市"
    }
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 24
    }
  }, [_c('el-select', {
    attrs: {
      "size": "",
      "placeholder": "请选择城市"
    },
    on: {
      "change": function($event) {
        _vm.getCity($event)
      }
    },
    model: {
      value: (_vm.selectCity),
      callback: function($$v) {
        _vm.selectCity = $$v
      },
      expression: "selectCity"
    }
  }, _vm._l((_vm.citys), function(item) {
    return _c('el-option', {
      attrs: {
        "label": item.label,
        "value": item.value
      }
    })
  }))], 1)], 1)], 1)], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 633:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(576);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("65cf45b6", content, true);

/***/ }),

/***/ 634:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(577);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(137)("ae188364", content, true);

/***/ })

});