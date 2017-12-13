$().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
  $("#loginForm").validate({
    rules: {
      username: "required",
      password: "required",
      code: "required"
    },
    messages: {
      username: "账号不能为空!",
      password: "密码不能为空!",
      code: "验证码不能为空!"
    }
  });
});