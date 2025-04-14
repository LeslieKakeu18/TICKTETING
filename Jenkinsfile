pipeline {
    agent any

    environment {
        IMAGE_NAME = "laravel-app"
    }

    stages {
        stage('📥 Checkout du code') {
            steps {
                git branch: 'main', url: 'https://github.com/TON_UTILISATEUR/TON_REPO.git'
            }
        }

        stage('🐳 Build Docker') {
            steps {
                sh 'docker-compose build'
            }
        }

        stage('🧪 Lancer les tests') {
            steps {
                sh 'docker-compose run --rm app php artisan test'
            }
        }

        stage('🚀 Déploiement') {
            steps {
                sh 'docker-compose up -d'
            }
        }
    }

    post {
        success {
            echo "✅ Déploiement réussi !"
        }
        failure {
            echo "❌ Le pipeline a échoué."
        }
    }
}
