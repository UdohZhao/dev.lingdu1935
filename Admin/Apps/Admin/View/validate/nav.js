$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#navForm").validate({
    rules: {
      cname: "required",
      type: "required"
    },
    messages: {
      cname: "导航名称不能为空！",
      type: "请选择相应的类型！"
    }
  });
});