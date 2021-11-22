<template id="contentBody">
  <v-form id="form">
    <v-container id="container-form">
      <figure id="container-img">
        <img src="../assets/images/logo.png" />
        <figcaption>Pineapplestorm</figcaption>
      </figure>
      <v-text-field
        type="text"
        color="#ffb406"
        label="Login"
        class="text"
        v-model="login"
      />
      <v-text-field
        type="password"
        color="#ffb406"
        label="Senha"
        class="text"
        v-model="senha"
      />
      <div id="botoes">
        <v-btn color="#ffb500" id="entrar" @click="authenticate()"
          >Entrar</v-btn
        >
      </div>
    </v-container>
  </v-form>
</template>

<script>
export default {
  data() {
    return {
      login: "",
      senha: "",
    };
  },
  name: "TelaLogin",
  methods: {
    authenticate() {
      if (this.login == "admin" && this.senha == "123") {
        this.$router.push("/");
      } else {
        alert("Login ou senha invalidos");
      }
    },
  },
};
</script>

<style lang="sass" scoped>
#form
    position: fixed
    top: 50%
    left: 50%
    transform: translate(-50%, -50%)

    background-color: #262b2f

    box-sizing: border-box
    padding: 25px 15px

    border-radius: 8px

    width: 25%

    translate: ease .3s

    @media (max-width: 1023px)
        width: 50%

    @media (max-width: 849px)
        width: 100%
        height: 100%

        display: flex
        flex-direction: flex
        align-items: center
        justify-content: center

#container-img
    width: 100%

    img
        width: 160px
        margin: 0 auto

    figcaption
        font-weight: bold
        font-size: 26px
        letter-spacing: 1px
        color: #ffb406

.text
    width: 50%

    margin: 0 auto

#esqueceu-senha
    font-size: 14px
    text-align: end

    display: block

    margin: 0 auto
    margin-bottom: 15px

    width: 50%

#entrar
    color: #fff

    margin-bottom: 15px

#botoes
    display: flex
    flex-direction: column

    width: 35%
    margin: 0 auto
</style>
