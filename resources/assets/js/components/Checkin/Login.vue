<template>
    <section class="section-login-confirm">
        <div class="content">
            <div v-if="showLoginOptionsScreen">
                <div class="top">
                    <button class="btn btn-facebook" type="button" @click="doFacebookLogin()">Kontynuuj z Facebookiem</button>
                </div>

                <div class="or">lub</div>

                <div class="bottom">
                    <button type="button" class="btn btn-transparent" @click="chooseManualDataProvider()">Podaj dane ręcznie</button>
                </div>
            </div>
            <div v-else-if="waitingForProfileData" class="loading text-center">
                Ładowanie...
            </div>
            <div v-else>
                <p v-if="chosenDataProvider == 'facebook'">
                    Czy poniższe dane są poprawne?
                </p>
                <div :class="['form-group', {'has-error': $v.email.$error}]">
                    <label class="control-label" for="email">E-mail</label>
                    <input autocomplete="off" class="form-control" v-model="email" @blur="$v.email.$touch()" id="email" name="email">
                    <p class="help-block" v-if="!$v.email.required && $v.email.$error">To pole jest wymagane</p>
                    <p class="help-block" v-if="!$v.email.email && $v.email.$error">Nieprawidłowy adres e-mail</p>
                </div>
                <div :class="['form-group', {'has-error': $v.name.$error}]">
                    <label class="control-label" for="name">Imię i nazwisko</label>
                    <input autocomplete="off" class="form-control" v-model="name" @blur="$v.name.$touch()" id="name" name="name">
                    <p class="help-block" v-if="!$v.name.required && $v.name.$error">To pole jest wymagane</p>
                    <p class="help-block" v-if="!$v.name.minLength && $v.name.$error">Wpisz minimum 5 znaków</p>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label" for="size-reprise">Rozmiar koszulki</label>
                    <input autocomplete="off" class="form-control" :value="displayChosenSize" id="size-reprise" disabled>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-default btn-primary btn-margin" :disabled="$v.$invalid" v-on:click="dispatchSendAction()">
                        {{ $v.$invalid ? 'Wypełnij wszystkie pola': 'Przejdź dalej' }}
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { default as mixins } from './mixins';
    import { mapState, mapActions, mapGetters } from 'vuex'
    import { required, email, minLength } from 'vuelidate/lib/validators'

    export default {
        mixins: [mixins],

        computed: {
            ...mapState([
                'chosenDataProvider',
            ]),

            ...mapGetters([
                'showLoginOptionsScreen'
            ]),

            ...mapState({
                waitingForProfileData: (state) => state.facebook.waitingForProfileData,
            }),

            email: {
                get() {
                    return this.$store.state.userInput.email;
                },
                set(value) {
                    this.$store.commit('setEmail', value === '' ? null : value);
                }
            },

            name: {
                get() {
                    return this.$store.state.userInput.name;
                },
                set(value) {
                    this.$store.commit('setName', value === '' ? null : value);
                }
            },

            displayChosenSize() {
                return this.$store.state.staticData.shirtSizes[this.$store.state.userInput.chosenSize];
            }
        },

        validations: {
            name: {
                required,
                minLength: minLength(5),
            },
            email: {
                required,
                email,
            }
        },

        methods: {
            chooseManualDataProvider() {
                this.$store.commit('chooseDataProvider', 'manual')
            },

            ...mapActions([
                'doFacebookLogin',
                'dispatchSendAction'
            ])
        },
    }
</script>
