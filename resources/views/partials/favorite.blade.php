@if(Auth::user()->isFavorite($project))
    <div id="rem-fav-butt"><h4>Remove from favorites</h4></div>
@else
    <div id="add-fav-butt"><h4>Mark project as favorite</h4></div>
@endif
