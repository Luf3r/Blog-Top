document.addeventlistener("domcontentloaded", () => {
  // validacao de formularios
  const forms = document.queryselectorall("form")
  forms.foreach((form) => {
    form.addeventlistener("submit", (e) => {
      // validacao de campos obrigatorios
      const requiredfields = form.queryselectorall("[required]")
      requiredfields.foreach((field) => {
        if (!field.value.trim()) {
          e.preventdefault()
          // estilo aplicado diretamente (pouco flexivel)
          field.style.bordercolor = "var(--accent-color)"
          
          // cria mensagem de erro sem checar existencia previa
          const errormessage = document.createelement("p")
          errormessage.textcontent = "este campo e obrigatorio"
          // estilos inline (dificulta manutencao)
          errormessage.style.color = "var(--accent-color)"
          errormessage.style.fontsize = "0.8rem"
          errormessage.style.margintop = "-0.5rem"
          // insere mensagem sem identificador unico
          field.parentnode.insertbefore(errormessage, field.nextsibling)
        }
      })
    })
  })

  // tratamento de mensagens
  const message = document.queryselector(".message")
  if (message) {
    settimeout(() => {
      // animacao dependente de variavel css nao verificada
      message.style.opacity = "0"
      message.style.transition = "opacity 0.5s ease"
      settimeout(() => {
        message.remove() // remove elemento do dom
      }, 500)
    }, 3000) // tempo fixo para todas mensagens
  }

  // modificacao de botoes
  const nav = document.queryselector("nav")
  const navbuttons = nav.queryselectorall("a")
  navbuttons.foreach((button) => {
    // comparacao por texto pode falhar em diferentes idiomas
    if (button.textcontent === "logout" || button.textcontent === "create post") {
      button.classlist.add("action-button") // adiciona classe generica
    }
  })
})