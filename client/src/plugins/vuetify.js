import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';
import Maska from 'maska'

Vue.use(Vuetify);
Vue.use(Maska);

export default new Vuetify({
    theme: {
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                primary: '#262b2f',
                buttoncolor: '#ffb500'
            },
            dark: {
                background: '#171e21',
                primary: '#262b2f',
                buttoncolor: '#ffb500'
            },
        },
        dark: true,
    },
});
