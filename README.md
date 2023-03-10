
# QuickBid

QuickBid is a simple auction system that allows users to create and participate in auctions. The system is built using PHP, Yii2 framework, MySQL, Redis, and RabbitMQ.


##  Directory Structure

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources

## Prerequisites

Before you can run QuickBid, you need to have the following installed:

-   Docker
-   Docker Compose

## Installation

To install and run QuickBid, follow these steps:

1.  Clone the Git repository:
    
    `git clone https://github.com/AnikanovD/quickbid.git` 
    
2.  Build the Docker containers:

    `cd quickbid
    docker-compose build` 
    
3.  Start the Docker containers:
    
    `docker-compose up` 
    
4.  Open your browser and go to `http://localhost:8080`. You should see the QuickBid home page.
    

## Usage

To use QuickBid, follow these steps:

1.  Create an account by clicking on the "Sign up" button on the home page.
    
2.  Create an auction by clicking on the "Create Auction" button on the home page.
    
3.  Participate in an auction by clicking on the auction name and placing a bid.
    
4.  End an auction by clicking on the "End Auction" button if you are the auction owner or wait until the auction ends automatically.
    


## Contact

If you have any questions or suggestions, please contact me at my email: [anikanovd@example.com](mailto:anikanovd@example.com).
