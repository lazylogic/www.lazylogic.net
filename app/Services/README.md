# /app/Services

* Kollus
* Order
* Payment
* Promotion

---
## Service Layout
* /app/Services
  + /Service/Contracts `Interfaces`
    - ServiceAgent `External`
    - ServiceBloker `Internal`

  + /Service/Exceptions
    - ServiceException

  + /Service/Facades
    - ServiceFacade

  + /Service/Strategies `Concrete Classes`
    - ServiceStrategy `implements Contracts`

  + /Service
    - Service
    - ServiceFactory
    - ServiceProvider
