pipeline {
    agent any

    environment {
        COMPOSE_PROJECT_NAME = "ticketing"
    }

    stages {
        stage('📥 Checkout du code') {
            steps {
                git credentialsId: 'github_pat',
                    url: 'https://github.com/LeslieKakeu18/TICKTETING.git',
                    branch: 'master'
            }
        }

        stage('📦 Build Docker') {
            steps {
                bat 'docker-compose build'
            }
        }

        stage('🧪 Lancer les tests') {
            steps {
                bat '''
                docker-compose up -d db
                timeout /T 20
                docker-compose run --rm app sh -c "
                    php artisan config:clear &&
                    php artisan migrate --force &&
                    php artisan test
                "
                '''
            }
        }

        stage('🚀 Déploiement Docker') {
            when {
                expression { currentBuild.result == null || currentBuild.result == 'SUCCESS' }
            }
            steps {
                echo "✅ Déploiement effectué (ou à compléter ici)"
                // Tu pourrais ajouter ici un `docker-compose up -d` si tu veux garder l'app active
            }
        }
    }

    post {
        failure {
            echo '❌ Le pipeline a échoué.'
        }
    }
}
