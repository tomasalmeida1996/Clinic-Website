# NextGen-Clinic-Website
WAMP Stack Clinic website

Languages used in this project: PHP, HTML, CSS, Javascript, MySQL (MariaDB).

NextGen is a medical consultation software system, which also embodies a fertility prediction system in order to recomend a decision to the apointed doctor (decision support system). A decision tree was developed to build this recomendation system.

Currently, there are four types of user: Patient, Doctor (obstetrician), Statistitian and Administrator.

Available options description:
1. List patients - returns a list of 10 patients ordered by Name for each page. In case the Administrator is logged in, he can also see all other clinic users (doctors and statistitian).
2. User registration - Allows the creation of new clinic user acounts by the administrator.
3. Insert patient parameters.
4. Visualize user profile.
5. Visualize patient profile.
6. Edit user profile.
7. Deactivate user.
8. Register new consult data.
9. Send emails with consult results.
10. Show statistics.

The following database structure was used: <br/>
![List Pacients](images/DB_tablesstructure.png)
