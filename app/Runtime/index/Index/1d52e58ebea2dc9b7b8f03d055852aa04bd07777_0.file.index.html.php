<?php
/* Smarty version 3.1.31, created on 2017-05-25 17:57:19
  from "D:\UPUPW_AP5.6\vhosts\tinyphp.net\app\index\view\Index\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5926aa7f6594b4_50140469',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d52e58ebea2dc9b7b8f03d055852aa04bd07777' => 
    array (
      0 => 'D:\\UPUPW_AP5.6\\vhosts\\tinyphp.net\\app\\index\\view\\Index\\index.html',
      1 => 1495706237,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5926aa7f6594b4_50140469 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>演示服务器向客户端推送消息</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style media="screen">
        #list-box {
            height: 300px;
            overflow-y: scroll;
        }
        #send-box {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">聊天窗口</h4>
                    </div>

                    <div class="panel-body">
                        <div id="list-box">
                            接收来自服务器的消息
                        </div>

                        <div id="send-box">
                            <textarea name="content" id="content" style="resize:none;" rows="5" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="panel-footer text-right">
                        <button class="btn btn-primary" id="btn_send">发送消息(ctrl+Enter)</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo '<script'; ?>
 src="/js/jquery.min.js" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/js/bootstrap.min.js" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        $(function(){
            var io = new WebSocket( "ws://tinyphp.net:2345" )

            io.onopen = function(){
                console.info( "连接服务器成功" )
                $('#list-box').append('<p class="alert alert-success">连接服务器成功！</p>')
            }

            // 监听服务器消息事件推送
            io.onmessage = function( event ){
                console.info( event.data )
                $('#list-box').append('<p class="alert alert-success">'+event.data+'</p>')
                var scrollTop = $('#list-box')[0].scrollHeight
                $('#list-box').scrollTop(scrollTop+$('.alert'))
            }

            // 服务器断开连接
            io.onclose = function(){
                console.log( "断开连接" )
            }

            // 错误信息
            io.onerror = function(){
                alert("连接服务器失败！")
            }

            if ( io ) {
                $('#btn_send').click(function(event){
                    // 向服务器发送群聊消息
                    data = "type=all&content=" + $('#content').val()

                    io.send(data)
                    // 清空
                    $('#content').val("")
                    // 发送完之后滚动条滚动到最下面


                })

                $(document).keydown(function(event){
                    if ( event.ctrlKey && event.keyCode == 13 ) {
                        $('#btn_send').click();
                    }
                })
            }


        })
    <?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
