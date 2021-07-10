<template>
    <transition name="fade">
    <div class="movie-list">
        <div class="search-bar">
            <div class="icon">
                <img src="/images/icons/search.svg" width="32px" height="32px" />
            </div>

            <input
                v-model="search"
                @keyup="queueFetch()"
                class="search-query"
                type="text"
                placeholder="Search for movies"
                />
        </div>

        <div v-if="isLoading" class="loading">
            <img src="/images/loading.svg" alt="Loading..." />
        </div>

        <div v-else>
            <div class="movies">
                <movie-card
                    v-for="movie in movies"
                    :key="movie.id"
                    :id="movie.data.id"
                    :prefetched="movie"></movie-card>
            </div>
        </div>
    </div>
    </transition>
</template>

<script>
const typeFetchDelay = 500

export default {
    data() {
        return {
            movies: [],
            search: '',
            queuedFetch: null,
            isLoading: true
        }
    },
    computed: {
    },
    mounted() {
        this.fetch()
    },
    methods: {
        queueFetch() {
            if(this.queuedFetch != null) {
                clearTimeout(this.queuedFetch)
            }

            this.queuedFetch = setTimeout(this.fetch, typeFetchDelay)
        },
        fetch() {
            this.isLoading = true

            let params = new URLSearchParams()

            if(this.search != '') {
                params.append('search', this.search)
            }

            window.axios.get('/api/movies?'+params.toString())
                .then(response => {
                    this.movies = response.data
                    this.isLoading = false
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

    .loading {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-bar {
        display: block;
        width: 100%;
        margin-bottom: 1rem;
        background: transparentize($black, 0.5);
        border-radius: 0.4em;
        display: flex;
        align-items: center;
    }

    .icon {
        margin-left: 1rem;
        opacity: 0.8;
    }

    .search-query {
        background: transparent;
        font-size: 1.5rem;
        padding: 0.75em;
        width: 100%;
        border: 0;
        outline: 0;
        color: $white;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
