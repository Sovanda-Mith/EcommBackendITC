import {
  Body,
  Controller,
  Delete,
  Get,
  Param,
  Patch,
  Post,
} from '@nestjs/common';
import { TaskService } from './task.service';
import { CreateTaskDto } from './dto/create-task.dto';
import { UpdateTaskDto } from './dto/update-task.dto';

@Controller('tasks')
export class TasksController {
  constructor(private readonly taskService: TaskService) {}

  @Get('/')
  getAllTasks(): any {
    return this.taskService.getAllTasks();
  }

  @Get('/:id')
  getTask(@Param('id') id: number): any {
    return this.taskService.getTask(id);
  }

  @Post('/')
  createTask(@Body() createTaskDto: CreateTaskDto): any {
    return this.taskService.createTask(createTaskDto);
  }

  @Patch('/:id/done')
  markTaskAsDone(
    @Body() updateTaskDto: UpdateTaskDto,
    @Param('id') id: number,
  ): any {
    return this.taskService.updateTask(id, updateTaskDto);
  }

  @Patch('/:id/pending')
  markTaskAsPending(
    @Body() UpdateTaskDto: UpdateTaskDto,
    @Param('id') id: number,
  ): any {
    return this.taskService.updateTask(id, UpdateTaskDto);
  }

  @Delete('/clear-all')
  deleteAllTasks(): any {
    return this.taskService.deleteAllTasks();
  }

  @Delete('/:id')
  deleteTask(@Param('id') id: number): any {
    return this.taskService.deleteTask(id);
  }
}
