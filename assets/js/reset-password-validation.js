const validation = new JustValidate('#reset-pasword')

validation
  .addField('#password', [
    {
      rule: 'required',
    },
    {
      rule: 'password',
    },
  ])
  .addField('#password_confirmation', [
    {
      validator: (value, fields) => {
        return value === fields['#password'].elem.value
      },
      errorMessage: 'Passwords should match',
    },
  ])
  .onSuccess((event) => {
    document.getElementById('reset-pasword').submit()
  })
