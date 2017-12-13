$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#svmerchandiseForm").validate({
    rules: {
      banner_path: "required",
      merchandise_path: "required",
      show_title: "required",
      descriptionss: "required"
    },
    messages: {
      banner_path: "请上传封面图片!",
      merchandise_path: "请上传商品封面!",
      show_title: "展示标题不能为空!",
      descriptionss: "商品描述"
    }
  });
});