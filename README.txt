I have create and tested the module on drupal-8.7.3.
Following things need to be consideration.
1) If user enter a node id which does not exists in the system, it take user to 404.
2) If user enter a node id which does not belog to page type, it take user to 403.
3) If user enter a valid api key and node id, it take user to a page which have json data of node, containing - type, id, title and body.
4) if user enter a non valid api key, its return 403.