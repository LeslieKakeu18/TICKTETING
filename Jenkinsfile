pipeline {
    agent any

    environment {
        COMPOSE_INTERACTIVE_NO_CLI = 1
    }

    stages {
        stage('🔄 Checkout') {
            steps {
                checkout scm
            }
        }

        stage('🐳 Build Docker') {
            steps {
                bat 'docker-compose build'
            }
        }

        stage('🧪 Lancer les tests') {
            steps {
                bat '''
                docker-compose up -d db
                timeout /T 20 >nul

                docker-compose run --rm app sh -c "until mysql -h db -uroot -proot -e 'SELECT 1' > /dev/null 2>&1; do echo '⏳ En attente de MySQL...'; sleep 2; done; echo '✅ MySQL est prêt !'; php artisan migrate --force && php artisan test"
                '''
            }
        }
    }

    post {
        failure {
            echo "❌ Le pipeline a échoué."
        }
        success {
            echo "✅ Le pipeline a réussi."
        }
    }
}
