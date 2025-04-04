export const getFavorites = () => {
    const data = localStorage.getItem('favoriteCountries');
    return data ? JSON.parse(data) : [];
};

export const setFavorites = (favorites) => {
    localStorage.setItem('favoriteCountries', JSON.stringify(favorites));
};

export const addFavorite = (country) => {
    const favorites = getFavorites();
    if (!favorites.find((fav) => fav.id === country.id)) {
        favorites.push(country);
        setFavorites(favorites);
    }
};

export const removeFavorite = (countryId) => {
    let favorites = getFavorites();
    favorites = favorites.filter((fav) => fav.id !== countryId);
    setFavorites(favorites);
};
