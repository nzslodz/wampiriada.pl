<template>
    <section class="statistics">
        <div class="content">
            <h3>Dane statystyczne</h3>
            <div class="form-group">
                <label for="">Oddaję (pierwszy raz/kolejny raz)</label>
                <button type="button" :class="['btn', 'btn-lg', 'btn-toggle', {'active': firstTime}]" v-bind:aria-pressed="firstTime ? 'true' : 'false'" autocomplete="off" @click="setFirstTime()">
                    <div class="handle"></div>
                </button>
            </div>

            <div :class="['form-group', {'has-error': $v.bloodType.$error}]">
                <label for="blood_type" class="control-label">Grupa krwi</label>
                <select name="blood_type" id="blood_type" class="form-control" v-model="bloodType" @input="$v.bloodType.$touch()">
                    <option value>---</option>
                    <option v-for="(name, id) in staticBloodTypes" :value="id">{{ name }}</option>
                </select>
                <p class="help-block" v-if="!$v.bloodType.required && $v.bloodType.$error">To pole jest wymagane</p>
            </div>

            <div :class="['form-group', {'has-error': $v.shirtSize.$error}]">
                <label class="control-label" for="size">Rozmiar koszulki</label>
                <select name="size" id="size" class="form-control" v-model.number="shirtSize" @input="$v.shirtSize.$touch()">
                    <option value>---</option>
                    <option v-for="(name, id) in staticShirtSizes" :value="id">{{ name }}</option>
                </select>
                <p class="help-block" v-if="!$v.shirtSize.required && $v.shirtSize.$error">To pole jest wymagane</p>
             </div>
            <button type="button" class="btn btn-default btn-primary" :disabled="$v.$invalid" v-on:click="nextStep()">
                {{ $v.$invalid ? 'Wypełnij wszystkie pola': 'Przejdź dalej' }}
            </button>
        </div>
    </section>
</template>

<script>
    import { default as mixins } from './mixins';
    import { mapState } from 'vuex'
    import { required } from 'vuelidate/lib/validators'


    export default {
        mixins: [mixins],

        computed: {
            ...mapState({
                staticShirtSizes: state => state.staticData.shirtSizes,
                staticBloodTypes: state => state.staticData.bloodTypes
            }),

            bloodType: {
                get() {
                    return this.$store.state.userInput.bloodType
                },
                set(value) {
                    this.$store.commit('setBloodType', value === '' ? null: value)
                }
            },

            shirtSize: {
                get() {
                    return this.$store.state.userInput.chosenSize
                },
                set(value) {
                    this.$store.commit('setShirtSize', value === '' ? null: value)
                }
            },

            firstTime() {
                return this.$store.state.userInput.firstTime
            },
        },

        methods: {
            setFirstTime() {
                this.$store.commit('setFirstTime', !this.$store.state.userInput.firstTime)
            }
        },

        validations: {
            bloodType: {
                required,
            },

            shirtSize: {
                required,
            }
        },

        mounted() {
            console.log('Component ready.')
        }
    }
</script>
