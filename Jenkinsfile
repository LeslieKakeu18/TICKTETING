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
                timeout /T 20
                docker-compose run --rm app sh -c "php artisan migrate --force && php artisan test"
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
