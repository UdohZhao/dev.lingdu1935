$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#allproductsForm").validate({
    rules: {
      banner_path: "required",
      show_title: "required"
    },
    messages: {
      banner_path: "请上传封面图片!",
      show_title: "展示标题不能为空!"
    }
  });
});