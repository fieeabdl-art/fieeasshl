package com.example.bumiyuji.ui.navigation

import androidx.compose.runtime.Composable
import androidx.lifecycle.viewmodel.compose.viewModel
import androidx.navigation.NavHostController
import androidx.navigation.NavType
import androidx.navigation.compose.NavHost
import androidx.navigation.compose.composable
import androidx.navigation.navArgument
import com.example.bumiyuji.BumiyujiApplication
import com.example.bumiyuji.ui.screens.*
import com.example.bumiyuji.ui.viewmodel.*

sealed class Screen(val route: String) {
    object Login : Screen("login")
    object Dashboard : Screen("dashboard")
    object Portfolios : Screen("portfolios")
    object Hero : Screen("hero")
    object Services : Screen("services")
    object ServiceForm : Screen("service_form") {
        fun createRoute(id: Int? = null) = if (id != null) "service_form?id=$id" else "service_form"
    }
    object Team : Screen("team")
    object TeamForm : Screen("team_form") {
        fun createRoute(id: Int? = null) = if (id != null) "team_form?id=$id" else "team_form"
    }
    object Settings : Screen("settings")
    object PortfolioForm : Screen("portfolio_form") {
        fun createRoute(id: Int? = null) = if (id != null) "portfolio_form?id=$id" else "portfolio_form"
    }
    object PortfolioDetail : Screen("portfolio_detail/{id}") {
        fun createRoute(id: Int) = "portfolio_detail/$id"
    }
    object PortfolioPhaseForm : Screen("portfolio/{portfolioId}/phase/{phaseId}") {
        fun createRoute(portfolioId: Int, phaseId: Int) = "portfolio/$portfolioId/phase/$phaseId"
    }
    object Projects : Screen("projects")
    object ProjectForm : Screen("project_form")
    object ProjectDetail : Screen("project_detail/{id}") {
        fun createRoute(id: Int) = "project_detail/$id"
    }
    object ProjectStageForm : Screen("project/{projectId}/stage_form") {
        fun createRoute(projectId: Int, stageId: Int? = null) =
            "project/$projectId/stage_form" + if (stageId != null) "?stageId=$stageId" else ""
    }
}

@Composable
fun NavGraph(
    navController: NavHostController,
    application: BumiyujiApplication
) {
    val factory = ViewModelFactory(
        application.authRepository,
        application.portfolioRepository,
        application.publicRepository,
        application.heroRepository,
        application.serviceRepository,
        application.teamRepository,
        application.settingRepository,
        application.projectRepository
    )

    NavHost(
        navController = navController,
        startDestination = Screen.Login.route
    ) {
        composable(Screen.Login.route) {
            val viewModel: LoginViewModel = viewModel(factory = factory)
            LoginScreen(
                viewModel = viewModel,
                onLoginSuccess = {
                    navController.navigate(Screen.Dashboard.route) {
                        popUpTo(Screen.Login.route) { inclusive = true }
                    }
                }
            )
        }

        composable(Screen.Dashboard.route) {
            val portfolioViewModel: PortfolioViewModel = viewModel(factory = factory)
            val projectViewModel: ProjectViewModel = viewModel(factory = factory)
            DashboardScreen(
                portfolioViewModel = portfolioViewModel,
                projectViewModel = projectViewModel,
                onNavigateToPortfolios = { navController.navigate(Screen.Portfolios.route) },
                onNavigateToProjects = { navController.navigate(Screen.Projects.route) },
                onNavigateToHero = { navController.navigate(Screen.Hero.route) },
                onNavigateToServices = { navController.navigate(Screen.Services.route) },
                onNavigateToTeam = { navController.navigate(Screen.Team.route) },
                onNavigateToSettings = { navController.navigate(Screen.Settings.route) },
                onLogout = {
                    navController.navigate(Screen.Login.route) {
                        popUpTo(0) { inclusive = true }
                    }
                }
            )
        }

        composable(Screen.Projects.route) {
            val viewModel: ProjectViewModel = viewModel(factory = factory)
            ProjectListScreen(
                viewModel = viewModel,
                onNavigateToAdd = { navController.navigate(Screen.ProjectForm.route) },
                onNavigateToDetail = { id -> navController.navigate(Screen.ProjectDetail.createRoute(id)) },
                onBackClick = { navController.popBackStack() }
            )
        }

        composable(
            route = Screen.ProjectDetail.route,
            arguments = listOf(navArgument("id") { type = NavType.IntType })
        ) { backStackEntry ->
            val id = backStackEntry.arguments?.getInt("id") ?: 0
            val viewModel: ProjectViewModel = viewModel(factory = factory)
            ProjectDetailScreen(
                viewModel = viewModel,
                projectId = id,
                onNavigateBack = { navController.popBackStack() },
                onNavigateToEdit = { projectId -> navController.navigate(Screen.ProjectForm.route + "?projectId=$projectId") },
                onNavigateToAddStage = { projectId -> navController.navigate(Screen.ProjectStageForm.createRoute(projectId)) },
                onNavigateToEditStage = { projectId, stageId ->
                    navController.navigate(Screen.ProjectStageForm.createRoute(projectId, stageId))
                }
            )
        }

        composable(
            route = Screen.ProjectForm.route + "?projectId={projectId}",
            arguments = listOf(navArgument("projectId") {
                type = NavType.StringType
                nullable = true
                defaultValue = null
            })
        ) { backStackEntry ->
            val projectId = backStackEntry.arguments?.getString("projectId")?.toIntOrNull()
            val viewModel: ProjectViewModel = viewModel(factory = factory)
            ProjectFormScreen(
                viewModel = viewModel,
                projectId = projectId,
                onNavigateBack = { navController.popBackStack() }
            )
        }

        composable(Screen.Portfolios.route) {
            val viewModel: PortfolioViewModel = viewModel(factory = factory)
            PortfolioListScreen(
                viewModel = viewModel,
                onNavigateToAdd = { navController.navigate(Screen.PortfolioForm.route) },
                onNavigateToDetail = { id -> navController.navigate(Screen.PortfolioDetail.createRoute(id)) },
                onBackClick = { navController.popBackStack() }
            )
        }

        composable(
            route = Screen.PortfolioDetail.route,
            arguments = listOf(navArgument("id") { type = NavType.IntType })
        ) { backStackEntry ->
            val id = backStackEntry.arguments?.getInt("id") ?: 0
            val viewModel: PortfolioViewModel = viewModel(factory = factory)
            PortfolioDetailScreen(
                viewModel = viewModel,
                portfolioId = id,
                onNavigateBack = { navController.popBackStack() },
                onNavigateToEditPortfolio = { portfolioId ->
                    navController.navigate(Screen.PortfolioForm.createRoute(portfolioId))
                },
                onNavigateToEditPhase = { portfolioId, phaseId ->
                    navController.navigate(Screen.PortfolioPhaseForm.createRoute(portfolioId, phaseId))
                }
            )
        }

        composable(
            route = Screen.PortfolioPhaseForm.route,
            arguments = listOf(
                navArgument("portfolioId") { type = NavType.IntType },
                navArgument("phaseId") { type = NavType.IntType }
            )
        ) { backStackEntry ->
            val portfolioId = backStackEntry.arguments?.getInt("portfolioId") ?: 0
            val phaseId = backStackEntry.arguments?.getInt("phaseId") ?: 0
            val viewModel: PortfolioViewModel = viewModel(factory = factory)
            PortfolioPhaseFormScreen(
                viewModel = viewModel,
                portfolioId = portfolioId,
                phaseId = phaseId,
                onNavigateBack = { navController.popBackStack() }
            )
        }

        composable(
            route = Screen.PortfolioForm.route + "?id={id}",
            arguments = listOf(navArgument("id") {
                type = NavType.StringType // Pass as string and parse to int
                nullable = true
                defaultValue = null
            })
        ) { backStackEntry ->
            val id = backStackEntry.arguments?.getString("id")?.toIntOrNull()
            val viewModel: PortfolioViewModel = viewModel(factory = factory)
            PortfolioFormScreen(
                viewModel = viewModel,
                portfolioId = id,
                onNavigateBack = { navController.popBackStack() }
            )
        }

        composable(Screen.Hero.route) {
            val viewModel: HeroViewModel = viewModel(factory = factory)
            HeroListScreen(
                viewModel = viewModel,
                onBackClick = { navController.popBackStack() }
            )
        }

        composable(Screen.Services.route) {
            val viewModel: ServiceViewModel = viewModel(factory = factory)
            ServiceListScreen(
                viewModel = viewModel,
                onBackClick = { navController.popBackStack() },
                onNavigateToAdd = { navController.navigate(Screen.ServiceForm.createRoute()) },
                onNavigateToEdit = { id -> navController.navigate(Screen.ServiceForm.createRoute(id)) }
            )
        }

        composable(
            route = Screen.ServiceForm.route + "?id={id}",
            arguments = listOf(navArgument("id") {
                type = NavType.StringType
                nullable = true
                defaultValue = null
            })
        ) { backStackEntry ->
            val id = backStackEntry.arguments?.getString("id")?.toIntOrNull()
            val viewModel: ServiceViewModel = viewModel(factory = factory)
            ServiceFormScreen(
                viewModel = viewModel,
                serviceId = id,
                onNavigateBack = { navController.popBackStack() }
            )
        }

        composable(Screen.Team.route) {
            val viewModel: TeamViewModel = viewModel(factory = factory)
            TeamListScreen(
                viewModel = viewModel,
                onBackClick = { navController.popBackStack() },
                onNavigateToAdd = { navController.navigate(Screen.TeamForm.createRoute()) },
                onNavigateToEdit = { id -> navController.navigate(Screen.TeamForm.createRoute(id)) }
            )
        }

        composable(
            route = Screen.TeamForm.route + "?id={id}",
            arguments = listOf(navArgument("id") {
                type = NavType.StringType
                nullable = true
                defaultValue = null
            })
        ) { backStackEntry ->
            val id = backStackEntry.arguments?.getString("id")?.toIntOrNull()
            val viewModel: TeamViewModel = viewModel(factory = factory)
            TeamFormScreen(
                viewModel = viewModel,
                profileId = id,
                onNavigateBack = { navController.popBackStack() }
            )
        }

        composable(Screen.Settings.route) {
            val viewModel: SettingViewModel = viewModel(factory = factory)
            SettingScreen(
                viewModel = viewModel,
                onBackClick = { navController.popBackStack() }
            )
        }

        composable(
            route = Screen.ProjectStageForm.route + "?stageId={stageId}",
            arguments = listOf(
                navArgument("projectId") { type = NavType.IntType },
                navArgument("stageId") {
                    type = NavType.StringType
                    nullable = true
                    defaultValue = null
                }
            )
        ) { backStackEntry ->
            val projectId = backStackEntry.arguments?.getInt("projectId") ?: 0
            val stageId = backStackEntry.arguments?.getString("stageId")?.toIntOrNull()
            val viewModel: ProjectViewModel = viewModel(factory = factory)
            ProjectStageFormScreen(
                viewModel = viewModel,
                projectId = projectId,
                stageId = stageId,
                onNavigateBack = { navController.popBackStack() }
            )
        }
    }
}
