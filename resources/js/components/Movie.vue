<template>
    <div class="movie">
        <div class="wrapper" v-if="isLoaded">
            <div class="poster">
                <img :src="data.poster_url" alt="Movie poster" width="300px" height="450px" />
            </div>

            <div class="vote">
                <p>Is <strong>{{ data.data.title }} <small>({{ data.release_year }})</small></strong> leftist?</p>

                <div class="votes-container">
                    <div class="votes yes-votes">
                        <button type="button" class="btn btn-success" @click="voteYes">Yes</button>
                        <div class="vote-count">{{ yesPercent }}</div>
                    </div>

                    <div class="votes no-votes">
                        <button type="button" class="btn btn-danger" @click="voteNo">No</button>
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
            data: []
        }
    },
    computed: {
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
                    console.log(this.data)
                })
                .catch(error => {
                    console.log(error)
                })
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
                    this.data = response.data
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

    .wrapper {
        display: flex;
        flex-direction: row;
        height: 100%;
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
        font-size: 2rem;
        padding: 2rem;

        .btn {
            font-size: 2rem;
            padding: 0.2rem 1.25rem;
            display: inline-block;
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
            font-size: 0.5em;
        }
    }
</style>
