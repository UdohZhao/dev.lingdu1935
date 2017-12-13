$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#productForm").validate({
    rules: {
      title: "required",
      picture_path: "required",
      original_cost: "required",
      promotion_price: "required"
    },
    messages: {
      title: "产品名称不能为空!",
      picture_path: "请上传产品图片!",
      original_cost: "产品原价不能为空!",
      promotion_price: "产品促销价不能为空!"
    }
  });
});