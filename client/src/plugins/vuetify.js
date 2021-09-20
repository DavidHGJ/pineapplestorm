import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                primary: '#262b2f'
            },
            dark: {
                background: '#171e21',
                primary: '#262b2f'
            },
        },
        dark: true,
    },
});
