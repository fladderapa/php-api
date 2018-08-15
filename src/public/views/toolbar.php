  <!-- Toolbar -->
  <header class="mdc-toolbar">
    <div class="mdc-toolbar__row">
      <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
        <a href="#" class="material-icons mdc-toolbar__menu-icon menu">menu</a>
        <span class="mdc-toolbar__title">API - Entries</span>
        <input id="searchValue" class="search-input" placeholder="Search" type="text" name="search">
        <button onclick="search()">Search</button>
      </section>
    </div>
<!-- Drawer -->
<aside class="mdc-drawer mdc-drawer--temporary mdc-typography">
  <nav class="mdc-drawer__drawer">
    <header class="mdc-drawer__header">
      <div class="mdc-drawer__header-content">
        API
      </div>
    </header>
    <nav class="mdc-drawer__content mdc-list">
      <a class="mdc-list-item mdc-list-item--activated" href="/add-user">
        <i class="material-icons mdc-list-item__graphic" aria-hidden="true">account_circle</i>Add user
      </a>
      <a class="mdc-list-item" href="/add-entry">
        <i class="material-icons mdc-list-item__graphic" aria-hidden="true">note</i>Add entry
      </a>
    </nav>
  </nav>
</aside>
  </header>