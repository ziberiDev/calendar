<nav x-data="nav()" x-init="getUsers()" class="navbar position-sticky top-0 navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Calendar <span
                    x-text="!$store.calendar.user ? 'My Calendar' : 'For ' + $store.calendar.user.name"></span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{\App\Core\Session\Session::get('user')->name}}
                    </a>
                    <ul class="dropdown-menu my-dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="logout">Logout</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Users
                    </a>
                    <ul class="dropdown-menu my-dropdown-menu" aria-labelledby="usersDropdown">
                        <template x-for="user in users">
                            <li><a @mouseover="$el.style.cursor = 'pointer'" class="dropdown-item"
                                   @click="$store.calendar.user = user"
                                   x-text="user.name + ' ' + user.last_name"></a></li>
                        </template>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>