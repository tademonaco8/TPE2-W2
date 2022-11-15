# TPE2-WEB2-REST
## API Endpoints
> An API REST to manage a CRUD service.
### URL:  api/lighters/
> - Method: GET
> - Returns an object with the list of *ALL* lighters.
### URL:  api/lighters?sortby=*columna*&order=*ASC/DESC*
> - Method: GET
> - Returns an object with the list of *ALL* lighters ordered by the specified column and the required order(ASC/DESC).
### URL:  api/lighters?category=*category*
> - Method: GET
> - Returns an object with the list of *ALL* lighters of the specified category.
### URL:  api/lighters/:ID
> - Method: GET
> - Returns an object with the lighter of the specified ID.
### URL:  api/lighters/:ID
> - Method: DELETE
> - Deletes the lighter with the specified ID.
### URL:  api/lighters/:ID
> - Method: PUT
> - Edits the specified lighter.
### URL:  api/lighters/
> - Method: POST
> - Creates a new lighter on the service.
