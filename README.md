# invitation create DataBase
Step 1:
        bin/console doctrine:database:create 
        
        bin/console make:entity
        
        bin/console make:migration 
       
        bin/console d:mig:mig


# invitation make user

Step 2:
        bin/console doctrine:fixtures:load
        

# invitation Run Test
Step 3:
        php bin/phpunit tests
 
 
# invitation Api Route
 
       @Route("/api/invitation/request/",  methods={"POST","HEAD"})
       @Route("/api/invitation/accept/" ,  methods={"PUT","HEAD"})
       @Route("/api/invitation/cancel/" ,  methods={"PUT","HEAD"})

# invitation JWT login

/api/login_check
/register
/api/test
