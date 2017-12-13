$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#mcategoriesForm").validate({
    rules: {
      category_name: "required"
    },
    messages: {
      category_name: "产品类别名称不能为空!"
    }
  });
});