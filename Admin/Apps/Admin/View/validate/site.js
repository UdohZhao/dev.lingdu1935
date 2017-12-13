$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#siteForm").validate({
    rules: {
      site_name: "required",
      logo_path: "required",
      banner_path: "required",
      copyright: "required"
    },
    messages: {
      site_name: "网站名称不能为空!",
      logo_path: "请上传Logo!",
      banner_path: "请上传banner!",
      copyright: "备案信息&版权所有不能为空!"
    }
  });
});