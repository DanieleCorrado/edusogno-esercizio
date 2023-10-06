const eventValidation = new JustValidate('#store')

eventValidation
  .addField('#name', [
    {
      rule: 'required',
    },
  ])
  .addField('#attendees', [
    {
      rule: 'required',
    },
  ])
  .addField('#date', [
    {
      rule: 'required',
    },
  ])
  .addField('#time', [
    {
      rule: 'required',
    },
  ])
  .onSuccess((event) => {
    document.getElementById('store').submit()
  })
