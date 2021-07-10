<template>
    <transition name="fade">
    <div class="movie">
        <div class="backdrop" v-if="isLoaded" :style="backdropStyle"></div>
        <div class="wrapper" v-if="isLoaded">
            <div class="poster">
                <img :src="movie.poster_url" alt="Movie poster" width="300px" height="450px" />
            </div>

            <div class="vote">
                <p class="prompt">Is <strong>{{ movie.data.title }} <small>({{ movie.release_year }})</small></strong> leftist?</p>

                <div class="votes-container">
                    <div class="votes yes-votes">
                        <button
                            v-if="isLoggedIn"
                            @click="voteYes"
                            type="button"
                            class="vote-button vote-button-yes"
                            :class="currentVote && currentVote.option == 'yes' ? 'is-selected' : ''"
                            >Yes</button>
                        <div v-if="!isLoggedIn" class="vote-label-yes vote-label">Yes</div>
                        <div class="vote-count">{{ movie.counts.yesPercent }}%</div>
                    </div>

                    <div class="votes no-votes">
                        <button
                            v-if="isLoggedIn"
                            @click="voteNo"
                            type="button"
                            class="vote-button vote-button-no"
                            :class="currentVote && currentVote.option == 'no' ? 'is-selected' : ''"
                            >No</button>
                        <div v-if="!isLoggedIn" class="vote-label-no vote-label">No</div>
                        <div class="vote-count">{{ movie.counts.noPercent }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="loading" v-if="!isLoaded">
            <div><img src="/images/loading.svg" alt="Loading..." /></div>
        </div>
    </div>
    </transition>
</template>

<script>
export default {
    props: [ 'id', 'prefetched' ],
    data() {
        return {
            movie: [],
            isLoaded: false,
            currentVote: null
        }
    },
    computed: {
        isLoggedIn() {
            return window.isLoggedIn
        },
        backdropStyle() {
            return 'background-image:url('+this.movie.backdrop_url+');'
        }
    },
    mounted() {
        if(this.prefetched == null) {
            this.update()
        } else {
            this.movie = this.prefetched
            this.updateVote()
        }
    },
    methods: {
        update() {
            window.axios.get('/api/movie/'+this.movie.id)
                .then(response => {
                    this.movie = response.data
                })
                .catch(error => {
                    console.log(error)
                })
                .then(this.updateVote())
        },
        updateVote() {
            if(this.isLoggedIn) {
                window.axios.get('/movie/'+this.movie.id+'/vote')
                    .then(response => {
                        this.currentVote = response.data
                        this.isLoaded = true
                    })
                    .catch(error => {
                        console.log(error)
                    })
            } else {
                this.isLoaded = true
            }
        },
        voteYes() {
            this.sendVote('yes')
        },
        voteNo() {
            this.sendVote('no')
        },
        sendVote(option) {
            this.currentVote = {
                option: option
            }

            window.axios.post('/movie/'+this.movie.id+'/vote', { option: option })
                .then(response => {
                    this.update()
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '~bulma/sass/utilities/_all';

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }

    .movie {
        background: #2a3036;
        border-radius: 1rem;
        position: relative;
        width: 100%;
        font-size: 1.15rem;
        height: 200px;

        @include tablet {
            font-size: 1.5rem;
            height: 300px;
        }
    }

    .prompt {
        margin-bottom: 0.5em;
    }

    .backdrop {
        z-index: 0;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border-radius: 1rem;
        opacity: 0.1;
        background-position: center center;
    }

    .wrapper {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: row;
        height: 100%;
        border-radius: 1rem;
    }

    .poster {
        flex: 0 0 auto;
        padding: 1rem;

        img {
            display: block;
            max-height: 100%;
            width: auto;
            border-radius: 0.4rem;
        }
    }

    .vote {
        flex: 1 1 auto;
        padding: 0.5em;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        text-align: center;
        line-height: 1em;

        .vote-button {
            font-size: 0.8em;
            margin: 0.25em;
            cursor: pointer;
            padding: 0.5em 1.25em;
            border-radius: 0.2em;
            display: inline-block;
            border: 3px solid transparent;
            transition: background-color 0.1s ease, transform 0.1s ease;
            color: #fff;
            background-color: $grey-dark;
            transform: scale(0.9);

            &.is-selected {
                transform: scale(1.1);
            }

            &.vote-button-yes {
                &.is-selected {
                    background-color: $success;
                    color: #fff;
                }
            }

            &.vote-button-no {
                &.is-selected {
                    background-color: #F03A5F;
                    color: #fff;
                }
            }
        }
    }

    .vote-label {
        padding: 0.5em;

        border-bottom: 6px solid transparent;

        &.vote-label-yes {
            border-color: #3EC487;
        }

        &.vote-label-no {
            border-color: #F03A5F;
        }
    }

    .loading {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .votes-container {
        display: flex;
        align-items: center;
        justify-content: center;

        .vote-count {
            font-size: 0.65em;
        }
    }
</style>
