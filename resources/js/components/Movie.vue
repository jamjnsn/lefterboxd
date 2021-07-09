<template>
    <div class="movie">
        <div class="backdrop" v-if="isLoaded" :style="backdropStyle"></div>
        <div class="wrapper" v-if="isLoaded">
            <div class="poster">
                <img :src="data.poster_url" alt="Movie poster" width="300px" height="450px" />
            </div>

            <div class="vote">
                <p>Is <strong>{{ data.data.title }} <small>({{ data.release_year }})</small></strong> leftist?</p>

                <div class="votes-container">
                    <div class="votes yes-votes">
                        <button
                            v-if="isLoggedIn"
                            @click="voteYes"
                            type="button"
                            class="vote-button vote-button-yes"
                            :class="currentVote && currentVote.score == 1 ? 'is-selected' : ''"
                            >Yes</button>
                        <div v-if="!isLoggedIn" class="vote-label-yes vote-label">Yes</div>
                        <div class="vote-count">{{ yesPercent }}</div>
                    </div>

                    <div class="votes no-votes">
                        <button
                            v-if="isLoggedIn"
                            @click="voteNo"
                            type="button"
                            class="vote-button vote-button-no"
                            :class="currentVote && currentVote.score == -1 ? 'is-selected' : ''"
                            >No</button>
                        <div v-if="!isLoggedIn" class="vote-label-no vote-label">No</div>
                        <div class="vote-count">{{ noPercent }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="loading" v-if="!isLoaded">
            <div>Loading...</div>
        </div>
    </div>
</template>

<script>
export default {
    props: [ 'id' ],
    data() {
        return {
            isLoaded: false,
            data: [],
            currentVote: null
        }
    },
    computed: {
        isLoggedIn() {
            return window.isLoggedIn
        },
        yesPercent() {
            if(this.data.total_votes > 0 && this.data.yes_votes > 0) {
                return ((this.data.total_votes / this.data.yes_votes) * 100) + '%'
            } else {
                return '0%'
            }
        },
        noPercent() {
            if(this.data.total_votes > 0 && this.data.no_votes > 0) {
                return ((this.data.total_votes / this.data.no_votes) * 100) + '%'
            } else {
                return '0%'
            }
        },
        backdropStyle() {
            return 'background-image:url('+this.data.backdrop_url+');'
        }
    },
    mounted() {
        this.update()
    },
    methods: {
        update() {
            window.axios.get('/api/movie/'+this.id)
                .then(response => {
                    this.data = response.data
                    this.isLoaded = true
                })
                .catch(error => {
                    console.log(error)
                })

            if(this.isLoggedIn) {
                window.axios.get('/movie/'+this.id+'/vote')
                    .then(response => {
                        this.currentVote = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },
        voteYes() {
            this.sendVote(1)
        },
        voteNo() {
            this.sendVote(-1)
        },
        sendVote(score) {
            window.axios.post('/movie/'+this.id+'/vote', { score: score })
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
    .movie {
        height: 300px;
        background: #eee;
        border-radius: 1rem;
        position: relative;
    }

    .backdrop {
        z-index: 0;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border-radius: 1rem;
        opacity: 0.3;
        background-position: center center;
    }

    .wrapper {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: row;
        height: 100%;
        backdrop-filter: blur(3px) saturate(0.4);
        border-radius: 1rem;
        background: #eee;
        background: radial-gradient(rgb(238, 238, 238), rgba(238,238,238,0));
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
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        text-align: center;
        font-size: 1.5rem;
        line-height: 1em;
        padding: 2rem;

        .vote-button {
            font-size: 1.5rem;
            padding: 0.5rem 1.25rem;
            border-radius: 0.2em;
            display: inline-block;
            border: 3px solid transparent;
            transition: background-color 0.1s ease, transform 0.1s ease;
            color: #fff;
            background-color: #2F2F2F;
            transform: scale(0.9);

            &.is-selected {
                transform: scale(1.1);
            }

            &.vote-button-yes {
                &.is-selected {
                    background-color: #3EC487;
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
        font-size: 1.5rem;
        padding: 0.5rem;

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

        .votes {
            padding: 0.5rem;
        }

        .vote-count {
            font-size: 0.55em;
        }
    }
</style>
