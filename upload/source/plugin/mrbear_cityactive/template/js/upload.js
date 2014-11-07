/**
 * Created by lenovo on 13-12-25.
 */
window.onerror=function(e){
    //alert(e);
}
var XICI=XICI||{};
XICI.Mobile=XICI.Mobile||{};
XICI.Mobile.post=function(){

}
XICI.Mobile.post.prototype={
    init:function(){
        var _=this;
        _.fileQueryNumber=0;
        _.bindEvent();
    },
    makeAjax:function(){
        return new XMLHttpRequest();
    },
    uploadFile:function(file){
        var _=this;
        _.rotate= _.rotate - Math.floor(_.rotate/360)*360;
        var fileType = "";
        if (/\.png/ig.test(file.name)) {
            fileType = "png";
        } else if (/\.jpg/ig.test(file.name) || /\.jpeg/ig.test(file.name)) {
            fileType = "jpeg";
        }else if (/\.gif/ig.test(file.name)) {
            fileType = "gif";
        }else if (/\.bmp/ig.test(file.name)) {
            fileType = "bmp";
        } else {
            fileType="";
        }


        if(fileType){
            var html="<li index='"+ _.fileQueryNumber+"'>读图中</li>";
            var d=$(html);
            d.insertBefore($(".images").children().eq(0));
            var r=new FileReader();

            r.onload=function(e){
                var b=r.result.replace("data:base64", "data:" + fileType + ";base64");
                d.html("").append($("<img src='"+b+"' style='-webkit-transform:rotate("+ _.rotate+"deg)'><div class='mask'></div><div class='close'></div>"));
                ajaxUpload(b);


            }
            r.readAsDataURL(file);

            function ajaxUpload(data){
                d.attr("pic_url",data);
                d.find(".mask").hide();
                $("#uploadPreview").hide();
                _.fillHiddenInput();
                return;
            }
        }
        else{

            alert("您上传的不是图片，或者您的浏览器不支持上传图片");
        }

    },
    convertDataURIToBinary:function(dataURI) {

        var BASE64_MARKER = ';base64,';
        var base64Index = dataURI.indexOf(BASE64_MARKER) + BASE64_MARKER.length;

        var base64 = dataURI.substring(base64Index);

        var raw = window.atob(base64);
        var rawLength = raw.length;
        var array = new Uint8Array(new ArrayBuffer(rawLength));
        for (i = 0; i < rawLength; i++) {
            array[i] = raw.charCodeAt(i);
        }
        return array.buffer;
    },
    bindEvent:function(){
        var _=this;

        $(".post_button").on(tapEvent,function(){
            document.forms[0].submit();
        });

        $("#fileUpload").on("change",function(e){
            var files=document.getElementById("fileUpload").files;
            if(files.length==0) return;
            _.previewFile(files[0]);
        })
        $(".images").on(tapEvent," .close",function(){
//            console.log(1);
            $(this).parent().remove();
            _.fillHiddenInput();
        })

    },
    previewFile:function(file){
        var _=this;
        var fileType = "";
        if (/\.png/ig.test(file.name)) {
            fileType = "image/png";
        } else if (/\.jpg/ig.test(file.name) || /\.jpeg/ig.test(file.name)) {
            fileType = "image/jpeg";
        }else if (/\.gif/ig.test(file.name)) {
            fileType = "image/gif";
        }else if (/\.bmp/ig.test(file.name)) {
            fileType = "image/bmp";
        } else {
            fileType="";
        }
        if(/image/i.test(fileType)){
            _.file=file;
            _.rotate=0;
            if(!$("#uploadPreview").length){
                var html="<div id='uploadPreview' class='upload_preview'>" +
                    "<div class='inner'>" +
                    "<div class='img'></div>" +
                    "<div class='shape'><span class='size'></span><span class='right'></span><span class='left'></span></div>" +
                    "<div class='buttons'><span class='upload'>确定并上传</span><span class='cancel'>取消</span></div>" +
                    "</div></div>";
                $(html).appendTo("body");
                $("#uploadPreview").on(tapEvent,function(e){
                    var tar= e.target;
                    if(tar.className=="upload" && tar.getAttribute("state")!="uploading"){
                        $(this).find(".upload").html("努力上传..").attr("state","uploading");
                        _.uploadFile(_.file);
                    }
                    if(tar.className=="cancel"){
                        $("#uploadPreview").hide();
                    }
                    if(tar.className=="left"){
                        _.rotate-=90;
                        $(this).find("img")[0].style.WebkitTransform="rotate("+ _.rotate+"deg) translate(-50%,-50%)";
                    }
                    if(tar.className=="right"){
                        _.rotate+=90;
                        $(this).find("img")[0].style.WebkitTransform="rotate("+ _.rotate+"deg) translate(-50%,-50%)";
                    }
                })


            }
            $("#uploadPreview .img").html("");
            $("#uploadPreview .size").html("");
            $("#uploadPreview .upload").html("确定并上传").attr("state","");
            $("#uploadPreview").show();
            var r=new FileReader();

            r.onload=function(e){
                var b=r.result.replace("data:base64", "data:" + fileType + ";base64");
                $("#uploadPreview .img").html("").append($("<img src='"+b+"'>"));
                $("#uploadPreview .size").html("大小:"+(file.size/1000>>0)+"Kb");
            }
            r.readAsDataURL(file);

        }else{
            alert("您上传的不是图片，或者您的浏览器不支持上传图片");
        }
    },
    fillHiddenInput:function(){
        var v=[];
        $(".images li").each(function(){
            if($(this).attr("pic_url")){
                v.push($(this).attr("pic_url"));
            }
//            console.log($(this));

        });
        $("#uploadImages").val(v.join(","));

    }

}
var p=new XICI.Mobile.post();
p.init();