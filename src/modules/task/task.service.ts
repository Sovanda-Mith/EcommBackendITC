import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Task } from 'src/tasks/task.entity';
import { Repository } from 'typeorm';

@Injectable()
export class UserService {
  constructor(
    @InjectRepository(Task)
    private tasksRepo: Repository<Task>,
  ) {}

  create(taskData: Partial<Task>) {
    const user = this.tasksRepo.create(taskData);
    return this.tasksRepo.save(user);
  }

  findAll() {
    return this.tasksRepo.find();
  }

  findOne(id: number) {
    return this.tasksRepo.findOne({ where: { id } });
  }

  async update(id: number, updateData: Partial<Task>) {
    await this.tasksRepo.update(id, updateData);
    return this.findOne(id);
  }

  remove(id: number) {
    return this.tasksRepo.delete(id);
  }
}
