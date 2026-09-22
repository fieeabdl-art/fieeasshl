package com.example.bumiyuji.ui.screens

import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.Add
import androidx.compose.material.icons.filled.Delete
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiLoading
import com.example.bumiyuji.ui.components.BumiyujiTopBar
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.HeroViewModel
import com.example.bumiyuji.util.FileUtils
import com.example.bumiyuji.util.ImageUtils
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun HeroListScreen(
    viewModel: HeroViewModel,
    onBackClick: () -> Unit
) {
    val context = LocalContext.current
    val launcher = rememberLauncherForActivityResult(
        contract = ActivityResultContracts.GetMultipleContents()
    ) { uris ->
        if (uris.isNotEmpty()) {
            val parts = uris.map { uri ->
                val file = FileUtils.uriToFile(uri, context)
                val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                MultipartBody.Part.createFormData("images[]", file.name, requestFile)
            }
            viewModel.uploadImages(parts)
        }
    }

    LaunchedEffect(Unit) {
        viewModel.fetchHeroSlides()
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(
                title = "Hero Slides",
                onBackClick = onBackClick
            )
        },
        floatingActionButton = {
            LargeFloatingActionButton(
                onClick = { launcher.launch("image/*") },
                containerColor = GoldAccent,
                contentColor = Color.White
            ) {
                Icon(Icons.Default.Add, contentDescription = "Add Hero Slide")
            }
        },
        containerColor = WarmCream
    ) { innerPadding ->
        val uiState = viewModel.uiState

        Box(modifier = Modifier.padding(innerPadding).fillMaxSize()) {
            when (uiState) {
                is UiState.Loading -> BumiyujiLoading()
                is UiState.Error -> Text(text = uiState.message, modifier = Modifier.align(Alignment.Center))
                is UiState.Success -> {
                    if (uiState.data.isEmpty()) {
                        Text(text = "Belum ada banner", modifier = Modifier.align(Alignment.Center), color = Color.Gray)
                    } else {
                        LazyColumn(
                            contentPadding = PaddingValues(16.dp),
                            verticalArrangement = Arrangement.spacedBy(16.dp)
                        ) {
                            items(uiState.data) { slide ->
                                HeroSlideItem(
                                    slide = slide,
                                    onDelete = { viewModel.deleteSlide(slide.id) }
                                )
                            }
                        }
                    }
                }
                else -> {}
            }
        }
    }
}

@Composable
fun HeroSlideItem(
    slide: com.example.bumiyuji.data.api.HeroSlideDto,
    onDelete: () -> Unit
) {
    Card(
        modifier = Modifier.fillMaxWidth(),
        shape = RoundedCornerShape(24.dp),
        colors = CardDefaults.cardColors(containerColor = Color.White),
        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp)
    ) {
        Column {
            Box {
                AsyncImage(
                    model = ImageUtils.resolveImageUrl(slide.image_url),
                    contentDescription = null,
                    modifier = Modifier
                        .fillMaxWidth()
                        .height(200.dp)
                        .clip(RoundedCornerShape(24.dp)),
                    contentScale = ContentScale.Crop
                )

                Surface(
                    modifier = Modifier.align(Alignment.TopEnd).padding(12.dp),
                    shape = CircleShape,
                    color = Color.Black.copy(alpha = 0.5f),
                    onClick = onDelete
                ) {
                    Icon(
                        Icons.Default.Delete,
                        contentDescription = "Delete",
                        tint = Color.White,
                        modifier = Modifier.padding(8.dp).size(20.dp)
                    )
                }
            }
            Row(
                modifier = Modifier.padding(16.dp).fillMaxWidth(),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Text(
                    text = "Slide Urutan ke-${slide.sort_order}",
                    style = MaterialTheme.typography.titleMedium,
                    fontWeight = FontWeight.Bold
                )
            }
        }
    }
}
