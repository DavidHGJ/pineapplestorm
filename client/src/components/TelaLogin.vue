<template>
    <v-form class="form">
        <figure>
            <img src="../assets/images/logo.png" width="100%" />
            <figcaption>
                PineappleStorm
            </figcaption>
        </figure>
        <v-text-field label="Digite seu e-mail" color="#ffb406" class="inputText" dark/>
        <v-text-field label="Digite sua senha" color="#ffb406" class="inputText" type="password" dark/>
        <div>
            <v-btn elevation-4 color="#ffb406" class="btn">Entrar</v-btn>
            <v-btn elevation-4 color="#fff" class="btn" outlined>Cadastrar</v-btn>
        </div>
    </v-form>
</template>

<script>
export default {
    name: 'TelaLogin'
}
</script>

<style lang="sass" scoped>
.form
    background-color: #333

    border-radius: 8px

    box-sizing: border-box
    padding: 50px 15px

    position: fixed
    top: 50%
    left: 50%
    transform: translate(-50%, -50%)

    width: 33%
    height: auto

    user-select: none

    @media (max-width: 1023px)
        width: 100%
        height: 100%
        border-radius: 0

    .inputText
        color: #fff

        width: 60%
        margin: 0 auto

    div
        display: flex
        flex-direction: column

    .btn
        font-weight: bold
        width: 120px
        
        margin: 0 auto
        margin-bottom: 15px

        &:last-child
            margin-bottom: 0

    figure
        display: flex
        flex-direction: column
        justify-content: center
        align-items: center

        width: 160px
        margin: 0 auto

        figcaption
            font-weight: bold
            font-size: 26px
            letter-spacing: 1px
            color: #ffb406
</style>